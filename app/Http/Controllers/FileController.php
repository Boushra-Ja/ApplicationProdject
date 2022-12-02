<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\FileStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class FileController extends Controller
{

    public function index()
    {
        //
    }


    public function store(StoreFileRequest $request)
    {

        $newfileName =  $request->name . '.' . $request->file->extension();
        $request->file->move(public_path('uploads\files'), $newfileName);
        File::create([
            'name' => $newfileName,
            'status_id' => FileStatus::where('status', 'حر')->value('id')
        ]);
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
        File::where('id' , $id)->delete() ;
    }
}
