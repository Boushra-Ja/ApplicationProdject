<?php

namespace App\Http\Resources;

use App\Models\Collection;
use App\Models\UserCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CollectionResource extends JsonResource
{
    public function toArray($request)
    {
        $user_id = Auth::id() ;

        return [

            'public_collection' => Collection::where('status' , 1 )->select('id' , 'name')->get() ,
            'my_collection' => UserCollection::where('user_id' , $user_id)->where('property' , 'owner')->get(),
            'other_collection' => UserCollection::where('user_id' , $user_id)->where('property' , 'user')->get(),
        ];
    }
}
