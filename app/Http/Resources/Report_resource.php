<?php

namespace App\Http\Resources;

use App\Models\File;
use App\Models\FileOperation;
use App\Models\FileStatus;
use App\Models\OperationType;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Report_resource extends JsonResource
{
    public function toArray($request)
    {
        $file=File::where('id',$this->file_id)->first();
        return [

            'file_name'=> $file->name ,
            'date'=> $this->created_at->format('Y.m.d H:i:s') ,
            'operation'=> OperationType::where('id' , $this->op_id)->value('type'),
            'user_name'=>User::where('id',$file->user_id)->value('username')


        ];
    }
}
