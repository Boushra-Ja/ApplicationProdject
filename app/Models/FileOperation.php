<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileOperation extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'file_id',
        'op_id','user_id'
    ];
}
