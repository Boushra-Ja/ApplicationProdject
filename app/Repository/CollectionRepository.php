<?php

namespace App\Repository;

use App\Models\Collection;
use App\Models\CollectionFile;
use App\Models\File;
use App\Models\User;
use App\Models\UserCollection;
use Illuminate\Support\Facades\Auth;

class CollectionRepository implements ICollectionRepository
{

    public function I_all_file_to_reserve()
    {
        $Collection = CollectionFile::whereIn('collection_id', UserCollection::where('user_id', Auth::id())->get('collection_id'))->get('file_id');
        $files_collection = File::whereIn('id', $Collection)->get();
        $files_owner_not_in_collection = File::whereNotIn('id', $Collection)->where('owner_id', Auth::id())->get();
        $files_public = File::whereIn('id', CollectionFile::where('collection_id', Collection::where('status', 'public')->value('id'))->get('file_id'))->whereNotIn('id', $Collection)->whereNot('owner_id', Auth::id())->get();


        $a = 0;
        $arr = array();
        foreach ($files_collection as $item) {
            $arr[$a] = $item;
            $a = $a + 1;
        }
        foreach ($files_owner_not_in_collection as $item) {
            $arr[$a] = $item;
            $a = $a + 1;
        }
        foreach ($files_public as $item) {
            $arr[$a] = $item;
            $a = $a + 1;
        }

        return $arr;
    }

    public function I_all_file_not_in_collection($collection_id)
    {
        return File::whereNotIn('id', CollectionFile::where('collection_id', $collection_id)->get('file_id'))->where('owner_id', Auth::id())->get();
    }

    public function I_show_all_users_in_collection($collection_id)
    {
        return User::whereIn('id', UserCollection::where('collection_id', $collection_id)->where('property', 'user')->get('user_id'))->get();
    }

    public function I_show_all_users_not_in_collection($collection_id)
    {
        $user_collection = User::whereIn('id', UserCollection::where('collection_id', $collection_id)->get('user_id'))->get('id');
        return User::whereNotIn('id', $user_collection)->get();
    }

    public function I_show_my_collection_file($collection_id)
    {
        return CollectionFile::where('collection_id', $collection_id)->get();
    }

    public function I_show_all_collection()
    {

        $user_collection = Collection::whereIn('id', UserCollection::where('user_id', Auth::id())->where('property', 'user')->get('collection_id'))->get();
        $public_collection = Collection::where('status', 'public')->first();
        $a = 0;
        $arr = array();
        $arr[$a] = $public_collection;
        $a = $a + 1;
        foreach ($user_collection as $item) {
            $arr[$a] = $item;
            $a = $a + 1;
        }
        return $arr;
    }

    public function I_show_my_collection()
    {
        return UserCollection::where('user_id', Auth::id())->where('property', 'owner')->get();

    }
}
