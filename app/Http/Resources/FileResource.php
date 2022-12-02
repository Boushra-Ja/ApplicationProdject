<?php

namespace App\Http\Resources;

use App\Models\FileStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{

    public function toArray($request)
    {
        return [

            'id' => $this->id ,
            'name'=> $this->name ,
            'status'=> FileStatus::where('id' , $this->status_id)->value('status')


        ];
    }
}
