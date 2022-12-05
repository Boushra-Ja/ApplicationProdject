<?php

namespace App\Http\Resources;

use App\Models\Collection;
use App\Models\File;
use App\Models\FileStatus;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class user_collection extends JsonResource
{

    public function toArray($request)
    {
        $collection=Collection::where('id',$this->collection_id)->first();
        return [

            'id' => $collection->id ,
            'name'=> $collection->name ,
            'property'=> $collection->property



        ];
    }
}
