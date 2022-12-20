<?php

namespace App\Repository;

interface IFileRepository{

    public function all_files() ;
    public function storage_file($file_name , $user_id) ;
    public function check_in_out($id , $user_id , $status , $operation);
}
