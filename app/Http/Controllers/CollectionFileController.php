<?php

namespace App\Http\Controllers;

use App\Models\CollectionFile;
use App\Http\Requests\StoreCollectionFileRequest;
use App\Http\Requests\UpdateCollectionFileRequest;

class CollectionFileController extends Controller
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
     * @param  \App\Http\Requests\StoreCollectionFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCollectionFileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollectionFile  $collectionFile
     * @return \Illuminate\Http\Response
     */
    public function show(CollectionFile $collectionFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CollectionFile  $collectionFile
     * @return \Illuminate\Http\Response
     */
    public function edit(CollectionFile $collectionFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCollectionFileRequest  $request
     * @param  \App\Models\CollectionFile  $collectionFile
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCollectionFileRequest $request, CollectionFile $collectionFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollectionFile  $collectionFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(CollectionFile $collectionFile)
    {
        //
    }
}
