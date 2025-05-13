<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    //

    protected $fillable = ['review','rating'] ;

    use HasFactory;
    public function book(){
        return $this->belongsTo(Book::class);
    }
}
