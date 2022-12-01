<?php

namespace App\Http\Controllers;

use App\Models\FileStatus;
use App\Http\Requests\StoreFileStatusRequest;
use App\Http\Requests\UpdateFileStatusRequest;

class FileStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreFileStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFileStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FileStatus  $fileStatus
     * @return \Illuminate\Http\Response
     */
    public function show(FileStatus $fileStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileStatus  $fileStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(FileStatus $fileStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFileStatusRequest  $request
     * @param  \App\Models\FileStatus  $fileStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileStatusRequest $request, FileStatus $fileStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileStatus  $fileStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileStatus $fileStatus)
    {
        //
    }
}
