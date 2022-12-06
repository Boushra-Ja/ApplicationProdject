<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\FileResource;
use App\Models\FileOperation;
use App\Models\FileStatus;
use App\Models\OperationType;
use App\Models\UserCollection;
use App\Repository\IFileRepository;
use Illuminate\Support\Facades\Auth;

class FileController extends BaseController
{

    private IFileRepository $file_repo ;


    public function __construct(IFileRepository $file_repo)
    {
        $this->file_repo = $file_repo ;
    }


    public function index()
    {

        $files = $this->file_repo->all_files() ;
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
        } else
        {
            $request->file->move(public_path('uploads\files\hh'), $newfileName);
            $file = File::create([
                'name' => $newfileName,
                'status_id' => FileStatus::where('status', 'حر')->value('id'),
                'owner_id' => $user_id,
                'user_id' => $user_id
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
        if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'حر')->value('id')) {
            File::where('id', $id)->delete();
            return $this->sendResponse('', 'the file deleted successfully');
        }
        return $this->sendErrors('error', 'error in delete file');
    }

    public function check_in($id , $user_id)
    {

        if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'حر')->value('id')) {
            File::where('id', $id)->first()->update(
                [
                    'status_id' => FileStatus::where('status', 'محجوز')->value('id')
                ]
            );

            FileOperation::create([

                'file_id' => $id ,
                'user_id' => $user_id,//Auth::id() ,
                'op_id' => OperationType::where('type' , 'حجز')->value('id')
            ]);


            return $this->sendResponse('', 'check in success');
        }
        return $this->sendErrors('error', 'the file is already rerserved');

    }

    public function check_out($id , $user_id)
    {

        if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'محجوز')->value('id')) {
            File::where('id', $id)->first()->update(
                [
                    'status_id' => FileStatus::where('status', 'حر')->value('id')
                ]
            );

            FileOperation::create([

                'file_id' => $id ,
                'user_id' =>  $user_id,// Auth::id() ,
                'op_id' => OperationType::where('type' , 'الغاء حجز')->value('id')
            ]);
            return $this->sendResponse('', 'check out success');
        }
        return $this->sendErrors('error', 'the file not rerserved');

    }

    public function myCollection()
    {
        return $this->sendResponse(new CollectionResource([]) , 'success') ;
    }

}
