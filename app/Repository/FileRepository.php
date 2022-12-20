<?php

namespace App\Repository;

use App\Models\File;
use App\Models\FileOperation;
use App\Models\FileStatus;
use App\Models\OperationType;
use Illuminate\Support\Facades\Auth;

class FileRepository implements IFileRepository
{
    public function all_files()
    {
        $user_id = Auth::id();
        $files = File::where('user_id', $user_id)->get();
        return $files;
    }

    public function storage_file($file_name , $user_id)
    {
        $file = File::create([
            'name' => $file_name,
            'status_id' => FileStatus::where('status', 'حر')->value('id'),
            'owner_id' => $user_id,
            'user_id' => $user_id
        ]);

        $op = FileOperation::create([
            'file_id' => File::where('name', $file_name)->value('id'),
            'user_id' => $user_id,
            'op_id' => OperationType::where('type', 'إضافة')->value('id')
        ]);

        return  ($file && $op ) ;
    }

    public function check_in_out($id , $user_id , $status , $operation)
    {
        $f = File::where('id', $id)->first()->update(
            [
                'status_id' => FileStatus::where('status', $status)->value('id')
            ]
        );

        $f2 = FileOperation::create([

            'file_id' => $id,
            'user_id' => $user_id, //Auth::id() ,
            'op_id' => OperationType::where('type', $operation)->value('id')
        ]);
        return ($f && $f2) ;

    }


}
