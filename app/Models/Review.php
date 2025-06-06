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

    public static function booted(){
        static::updated(fn(Review $review)=>cache()->forget('book:'.$review->book_id));
        static::deleted(fn(Review $review)=>cache()->forget('book:'.$review->book_id));
    }
}
