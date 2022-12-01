<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class , 'user_collections','user_id','collection_id',) ;
    }

    public function files()
    {
        return $this->belongsToMany(File::class , 'collection_files','file_id','collection_id',) ;
    }
}
