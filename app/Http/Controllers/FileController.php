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
use App\Models\UserCollection;
use Illuminate\Support\Facades\Auth;

class FileController extends BaseController
{

    public function index()
    {
        $user_id = 1;//Auth::id();
        $files = File::where('owner_id', $user_id)->get();
        if ($files) {
            return $this->sendResponse(FileResource::collection($files), "this is all files");
        }
        return $this->sendErrors([], 'error in retrived files');
    }


    public function store(StoreFileRequest $request)
    {

        $newfileName = $request->name . '.' . $request->file->extension();
        $user_id = 1 ; //Auth::id();
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
        if (File::where('id', $id)->where('status_id', FileStatus::where('status', 'حر')->value('id'))) {
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
                'user_id' => $user_id ,
                'op_id' => FileOperation::where('type' , 'حجز')->value('id')
            ]);


            return $this->sendResponse('', 'check in success');
        }
        return $this->sendErrors('error', 'the file is already rerserved');

    }

    public function check_out($id)
    {

        if (File::where('id', $id)->value('status_id') == FileStatus::where('status',  'محجوز')->value('id')) {
            File::where('id', $id)->first()->update(
                [
                    'status_id' => FileStatus::where('status', 'حر')->value('id')
                ]
            );
            return $this->sendResponse('', 'check out success');
        }
        return $this->sendErrors('error', 'the file not rerserved');

    }

    public function myCollection()
    {
       // $user_id = Auth::id() ;
        return $this->sendResponse(new CollectionResource([]) , 'success') ;
    }

}
