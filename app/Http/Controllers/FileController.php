<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Resources\FileResource;
use App\Http\Resources\user_collection;
use App\Models\Collection;
use App\Models\CollectionFile;
use App\Models\FileOperation;
use App\Models\FileStatus;
use App\Models\OperationType;
use App\Models\User;
use App\Models\UserCollection;
use App\Repository\IFileRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File as FacadesFile;

class FileController extends BaseController
{

    private IFileRepository $file_repo;


    public function __construct(IFileRepository $file_repo)
    {
        $this->file_repo = $file_repo;
    }


    public function index()
    {

        $files = $this->file_repo->all_files();
        if ($files) {
            return $this->sendResponse(FileResource::collection($files), "this is all files");
        }
        return $this->sendErrors([], 'error in retrived files');
    }



    public function store(StoreFileRequest $request)
    {

        $newfileName = $request->name . '.' . $request->file->extension();
        $user_id = Auth::id();

        if (File::where('name', $newfileName)->first()) {
            return $this->sendErrors([], 'the file name is exist ');
        } else {
            ///storage file in public folder
            $res = $request->file->storeAs('files', $newfileName, 'my_files');
            if (!$res) {
                return $this->sendErrors('error', "error in storage file");
            }
            ///storage file in DB
            $file = File::create([
                'name' => $newfileName,
                'status_id' => FileStatus::where('status', 'حر')->value('id'),
                'owner_id' => $user_id,
                'user_id' => $user_id
            ]);

            if (!$file) {
                return $this->sendErrors('error', 'errror in storage file');
            }

            ////storage operation in DB
            $f_op = FileOperation::create([
                'file_id' => File::where('name', $newfileName)->value('id'),
                'user_id' => $user_id,
                'op_id' => OperationType::where('type', 'إضافة')->value('id')
            ]);

            if (!$f_op) {
                return $this->sendErrors('error', 'error in storage operation on file');
            }
            return $this->sendResponse($file, 'success in create file');
        }
    }


    public function update($id, Request $request)
    {

        if (File::where('id', $id)->value('status_id') == FileStatus::where('status', 'محجوز')->value('id') && File::where('id', $id)->where('user_id', $request->user_id)->first()) {

            ////update file in public folder
            $image_name = File::where('id', $id)->value('name');
            $res = $request->file->storeAs('files', $image_name, 'my_files');

            if (!$res) {
                return $this->sendErrors('error', "error in storage file");
            }

            ///update file in DB
            $file = File::where('id', $id)->first();
            $file->update([
                'updated_at' => Date::now()
            ]);

            ///storage operation in DB
            $op_f = FileOperation::create([
                'file_id' => $id,
                'user_id' => Auth::id(),
                'op_id' => OperationType::where('type', 'تعديل')->value('id')
            ]);
            if (!$op_f) {
                return $this->sendErrors('error', "error in storage operation on file");
            }

            return $this->sendResponse(File::where('id', $request->id)->get(), 'success in create file');
        }
        return $this->sendErrors('error', "There is no permission to edit the file");
    }

    public function destroy($id, $user_id)
    {
        $user_id = Auth::id();
        if (
            File::where('id', $id)->value('status_id') == FileStatus::where('status',  'حر')->value('id')
            && File::where('id', $id)->where('owner_id', $user_id)->first()
        ) {
            ///delete file from public folder
            $name = File::where('id', $id)->value('name');
            $path = public_path('uploads/files/' . $name);
            FacadesFile::delete($path);

            ///delete file from DB
            File::where('id', $id)->delete();

            ///storage operation in DB
            FileOperation::create([
                'file_id' => $id,
                'user_id' => $user_id,
                'op_id' => OperationType::where('type', 'حذف')->value('id')
            ]);

            return $this->sendResponse('', 'the file deleted successfully');
        }
        return $this->sendErrors('error', 'error in delete file');
    }

    public function check_in($id, $user_id)
    {

        if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'حر')->value('id')) {
            File::where('id', $id)->first()->update(
                [
                    'status_id' => FileStatus::where('status', 'محجوز')->value('id')
                ]
            );

            FileOperation::create([

                'file_id' => $id,
                'user_id' => $user_id, //Auth::id() ,
                'op_id' => OperationType::where('type', 'حجز')->value('id')
            ]);


            return $this->sendResponse('', 'check in success');
        }
        return $this->sendErrors('error', 'the file is already rerserved');
    }

    public function check_out($id, $user_id)
    {

        if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'محجوز')->value('id')) {
            File::where('id', $id)->first()->update(
                [
                    'status_id' => FileStatus::where('status', 'حر')->value('id')
                ]
            );

            FileOperation::create([

                'file_id' => $id,
                'user_id' =>  $user_id, // Auth::id() ,
                'op_id' => OperationType::where('type', 'الغاء حجز')->value('id')
            ]);
            return $this->sendResponse('', 'check out success');
        }
        return $this->sendErrors('error', 'the file not rerserved');
    }

    public function myCollection()
    {
        $f = UserCollection::where('user_id', Auth::id())->get();
        $i = 0;
        // return $this->sendResponse(new CollectionResource([]) , 'success') ;
        foreach ($f as $value) {
            $files = CollectionFile::where('collection_id', $value['collection_id'])->get();

            foreach ($files as $val) {
                print($val);
            }
        }
    }


    public function check_many_files(Request $request)
    {
        $user_id = Auth::id();
        $ids = $request->ids;
        DB::transaction(function () use ($ids,  $user_id) {
            foreach ($ids as  $id) {
                if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'محجوز')->value('id')) {
                    DB::rollback();
                    throw new Exception('error');
                }
                FileController::check_in($id, $user_id);
            }

            DB::commit();
        });
        return $this->sendResponse("success", "All files are reserved");
    }

    public function admin_files()
    {
        return $this->sendResponse(FileResource::collection(File::all()), 'success');
    }

    public function admin_collections()
    {
        return $this->sendResponse(user_collection::collection(Collection::all()), 'success');
    }


}
