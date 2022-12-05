<?php

namespace App\Http\Resources;

use App\Models\File;
use App\Models\FileStatus;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class File_collection_resource extends JsonResource
{
    public function toArray($request)
    {
        $file=File::where('id',$this->file_id)->first();
        return [

            'id' => $file->id ,
            'name'=> $file->name ,
            'status'=> FileStatus::where('id' , $file->status_id)->value('status'),
            'user'=>User::where('id',$file->user_id)->value('username')


        ];
    }
}
