<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'author',
        'releaseYear'
    ];

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
