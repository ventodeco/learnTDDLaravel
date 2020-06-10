<?php

namespace App\Http\Controllers;

use App\Book;

class BookController extends Controller
{
    public function store()
    {
        Book::create($this->validateRequest());
    }
    
    public function update(Book $book)
    {
        $book->update($this->validateRequest());
    }

    public function validateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }
}
