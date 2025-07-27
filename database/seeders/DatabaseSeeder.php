<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Country;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $count_books = 50;
        $count_authors = 25;
         Country::factory(50)->create();
         Author::factory($count_authors)->create();
         Book::factory($count_books)->create();
         
         $books = Book::all();
         foreach ($books as $book)
         {
            $book->authors()->attach(random_int(1,$count_authors));
         }
         


        
    }
}
