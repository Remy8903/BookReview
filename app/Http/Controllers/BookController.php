<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Cache;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        // dd($request->book);
        $filter = $request->input("filter",'');
        $title = $request->input('title');


        $books = Book::when($title, function($query, $title){
            return $query->title($title);
        } );

        $books = match($filter){
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatedLastMonth(),
            'highest_rated_last_6month' => $books->highestRatedLast6Months(),
            default => $books->latest()
        };

        $cacheKey ='books:'.$filter.':'.$title;
        $books = cache()->remember($cacheKey , 3600, function() use($books){
            // dd('from not cache');
            return $books->get();
        });

        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
        $cacheKey = 'book:'.$book->id;

        $book = cache()->remember($cacheKey, 3600, fn()=>$book->load([
            'reviews'=>fn($query)=> $query->latest()
        ]));

        return view('books.show',['book'=>$book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}
