<?php

namespace App\Http\Resources;

use App\Models\File;
use App\Models\FileStatus;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class reserv_file extends JsonResource
{
    public function toArray($request)
    {
        return [

            'id' => $this->id ,
            'name'=> $this->name ,
            'status'=> $this->status,
            'user'=>User::where('id',$this->user_id)->value('username')


        ];
    }
}
