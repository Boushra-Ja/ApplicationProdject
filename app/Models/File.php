<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'status_id',
    ];

    public function collections()
    {
        return $this->belongsToMany(Collection::class);
    }
}
