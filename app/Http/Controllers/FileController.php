<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\FileResource;
use App\Models\CollectionFile;
use App\Models\FileOperation;
use App\Models\FileStatus;
use App\Models\OperationType;
use App\Models\UserCollection;
use App\Repository\IFileRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
            $request->file->move(public_path('uploads\files'), $newfileName);
            $file = File::create([
                'name' => $newfileName,
                'status_id' => FileStatus::where('status', 'حر')->value('id'),
                'owner_id' => $user_id,
                'user_id' => $user_id
            ]);

            FileOperation::create([

                'file_id' => File::where('name', $newfileName)->value('id'),
                'user_id' => $user_id,
                'op_id' => OperationType::where('type', 'إضافة')->value('id')
            ]);

            return $this->sendResponse($file, 'success in create file');
        }
    }



    public function show(File $file)
    {
        //
    }




    public function update(UpdateFileRequest $request, File $file)
    {
        //
    }


    public function destroy($id)
    {
        $user_id = Auth::id();
        if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'حر')->value('id')) {
            File::where('id', $id)->delete();
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
        $ids = $request->ids;
        DB::transaction(function () use ($ids){
            foreach ($ids as  $id) {
                if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'محجوز')->value('id')) {
                    DB::rollback() ;
                    throw new Exception('file ' . $id ." is reserved" ) ;
                }
                FileController::check_in($id , Auth::id() ) ;

            }

            DB::commit() ;
        });
    }

    public function admin_files()
    {
        return $this->sendResponse(FileResource::collection(File::all()) , 'success' );
    }
}
