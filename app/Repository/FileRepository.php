<?php

namespace App\Repository;

use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileRepository implements IFileRepository
{
    public function all_files()
    {
        $user_id = Auth::id();
        $files = File::where('user_id', $user_id)->get();
        return $files;
    }


}
