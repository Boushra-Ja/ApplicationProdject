<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\UserCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionAdmin extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id' => $this->id ,
            'name' => $this->name ,
            'status' => $this->status ,
            'owner' => User::where('id' , UserCollection::where('collection_id' , $this->id)->where('property' , 'owner')->value('user_id'))->value('username') ,
            'num_users' => UserCollection::where('collection_id' , $this->id)->count()

        ];
    }
}
