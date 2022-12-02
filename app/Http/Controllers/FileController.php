<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\FileStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

use function PHPUnit\Framework\isEmpty;

class FileController extends BaseController
{

    public function index()
    {
        $user_id = 1 ;
        ///user_id
        $files = File::where('user_id' , $user_id)->get() ;
        if($files)
        {
            return $this->sendResponse($files , "this is all files");
        }
        return $this->sendErrors([] , 'error in retrived files');

    }


    public function store(StoreFileRequest $request)
    {

        $newfileName = $request->name . '.' . $request->file->extension();

        if(File::where('name' , $newfileName)->first())
        {
            return $this->sendErrors([] , 'the file name is exist ');
        }
        else
        {
            $request->file->move(public_path('uploads\files'), $newfileName);
            $file = File::create([
                'name' => $newfileName,
                'status_id' => FileStatus::where('status', 'حر')->value('id')
            ]);
            return $this->sendResponse($file , 'success in create file');
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
        if( File::where('id' , $id)->where('status_id' , FileStatus::where('status' , 'حر')->value('id')))
            File::where('id' , $id)->delete() ;
    }
}
