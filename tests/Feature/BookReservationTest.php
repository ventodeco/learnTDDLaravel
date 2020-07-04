<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', [
            'title' => 'Cool Book',
            'author' => 'Vento Deco'
        ]);

        // $response->assertOk();
        $book = Book::first();
        

        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Vento Deco'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_author_is_required()
    {
        $response = $this->post('/books', [
            'title' => 'Cool Book',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/books', [
            'title' => 'Cool Book',
            'author' => 'Vento Deco'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'Judul Bagus',
            'author' => 'Deco'
        ]);
            
        $data = Book::first();
        
        $this->assertEquals('Judul Bagus', $data->title);
        $this->assertEquals('Deco', $data->author);
        $response->assertRedirect($book->fresh()->path());
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->post('/books', [
            'title' => 'Cool Book',
            'author' => 'Vento Deco'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response = $this->delete($book->path());
        
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }
}
