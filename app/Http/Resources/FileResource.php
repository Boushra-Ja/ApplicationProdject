<?php

namespace App\Http\Resources;

use App\Models\File;
use App\Models\FileStatus;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{

    public function toArray($request)
    {

        if(FileStatus::where('id' , $this->status_id)->value('status') == 'حر')
        {
            $name = '' ;
        }
        else{
            $name = User::where('id' , File::where('id' , $this->id)->value('user_id'))->value('username');
        }
        return [

            'id' => $this->id ,
            'name'=> $this->name ,
            'status'=> FileStatus::where('id' , $this->status_id)->value('status'),
            'user_name' => $name

        ];
    }
}
