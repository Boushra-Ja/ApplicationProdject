<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Http\Requests\StoreCollectionRequest;
use App\Http\Requests\UpdateCollectionRequest;
use App\Models\CollectionFile;
use App\Models\File;
use App\Models\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{

    public function __construct()
    {
        $this->middleware(["auth:sanctum"])->only(["add_user_to_collection", "delete_user_from_collection", "destroy"]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreCollectionRequest $request
     */
    public function store(StoreCollectionRequest $request)
    {

        $collection = Collection::create([
            'name' => $request->name,
        ]);

        if ($collection) {
            $user_collection = UserCollection::create([
                'collection_id' => $collection->id,
                'user_id' => Auth::id(),
                'property' => "owner"
            ]);
            return response()->json($collection, 200);

        } else {
            return response()->json("erorr", 201);
        }
    }

    public function add_file_to_collection($request)
    {
        $has_user = UserCollection::where('collection_id', '=', $request->collection_id)->where('user_id', '=', $request->user_id)->first();
        if (Auth::id() == $request->owner && $has_user) {
            $collection_file = CollectionFile::create([
                'collection_id' => $request->collection_id,
                'file_id' => $request->file_id,
            ]);

            if ($collection_file) {
                return response()->json($collection_file, 200);

            } else {
                return response()->json("erorr", 201);
            }
        }

    }

    public function delete_file_from_collection($request)
    {
        if (Auth::id() == $request->owner) {
            $collection_file = CollectionFile::where('collection_id', '=', $request->collection_id)->where('file_id', '=', $request->file_id)->first()->delete();


            if ($collection_file) {
                return response()->json($collection_file, 200);

            } else {
                return response()->json("erorr", 201);
            }
        }

    }

    public function add_user_to_collection(Request $request)
    {

        $has_user = UserCollection::where('collection_id', '=', $request->collection_id)->where('user_id', '=', $request->user_id)->first();
        if (!$has_user) {

            $user_collection = UserCollection::create([
                'collection_id' => $request->collection_id,
                'user_id' => $request->user_id,
                'property' => 'user'
            ]);

            if ($user_collection) {
                return response()->json($user_collection, 200);

            } else {
                return response()->json("erorr", 201);
            }
        }

    }

    public function delete_user_from_collection(Request $request)
    {
        $user_collection = UserCollection::where('collection_id', '=', $request->collection_id)->where('user_id', '=', $request->user_id)->first();
        if ($user_collection) {
            $user_collection1 = UserCollection::where('id', '=', $user_collection->id)->delete();
            if ($user_collection1) {
                return response()->json($user_collection1, 200);

            } else {
                return response()->json("erorr", 201);
            }
        }

    }

    public function add_file_to_public_collection(){

    }

    public function destroy(Request $collection)
    {

        Collection::where('id', '=', $collection->collection_id)->first()->delete();

    }
}
