<?php

namespace App\Http\Resources;

use App\Models\Collection;
use App\Models\UserCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class all_collection_resource extends JsonResource
{

    public function toArray($request)
    {
        return [

            'public_collection' => Collection::where('status' , 'public' )->first() ,
            'my_collection' => user_collection::collection($this),
        ];
    }
}
