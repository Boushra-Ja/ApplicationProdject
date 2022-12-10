<?php

namespace App\Http\Controllers;

use App\Http\Resources\Report_resource;
use App\Models\FileOperation;
use App\Http\Requests\StoreFileOperationRequest;
use App\Http\Requests\UpdateFileOperationRequest;

class FileOperationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function RepotFiles($file_id)
    {
         //->where('user_id', auth::id())
        $FileOperationModel=FileOperation::query()->where('file_id','=',$file_id)->orderBy('created_at', 'desc')->get();
        return Report_resource::collection($FileOperationModel);

       // return response()->json($FileOperationModel,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFileOperationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileOperationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileOperation  $fileOperation
     * @return \Illuminate\Http\Response
     */
    public function show(FileOperation $fileOperation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileOperation  $fileOperation
     * @return \Illuminate\Http\Response
     */
    public function edit(FileOperation $fileOperation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileOperationRequest  $request
     * @param  \App\Models\FileOperation  $fileOperation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileOperationRequest $request, FileOperation $fileOperation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileOperation  $fileOperation
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileOperation $fileOperation)
    {
        //
    }
}
