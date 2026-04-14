<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static array $bookData = [
        ['Pemrograman Web dengan PHP', 'Budi Raharjo', 'Informatika', 2024],
        ['Laravel Framework Essentials', 'Taylor Otwell', 'O\'Reilly', 2023],
        ['Database Design Patterns', 'Tom Kyte', 'Addison-Wesley', 2022],
        ['Clean Code: A Handbook', 'Robert C. Martin', 'Prentice Hall', 2023],
        ['The Pragmatic Programmer', 'David Thomas', 'Addison-Wesley', 2024],
        ['Refactoring: Improving Design', 'Martin Fowler', 'Addison-Wesley', 2021],
        ['Design Patterns', 'Gang of Four', 'Addison-Wesley', 2020],
        ['Software Architecture Patterns', 'Mark Richards', 'O\'Reilly', 2023],
        ['Testing JavaScript', 'Kent C. Dodds', 'Leanpub', 2022],
        ['You Don\'t Know JS Yet', 'Kyle Simpson', 'O\'Reilly', 2024],
        ['Eloquent JavaScript', 'Marijn Haverbeke', 'No Starch Press', 2024],
        ['JavaScript Design Patterns', 'Addy Osmani', 'O\'Reilly', 2023],
        ['DOM Scripting', 'Jeremy Keith', 'Friends of ED', 2021],
        ['Responsive Web Design', 'Ethan Marcotte', 'A Book Apart', 2022],
        ['Mobile Web Development', 'Remy Sharp', 'O\'Reilly', 2023],
        ['Web Performance Action Plan', 'Clay Farrow', 'Sitepoint', 2024],
        ['Building Scalable Applications', 'Matt Aimonetti', 'CoffeeScript Media', 2022],
        ['High Performance MySQL', 'Baron Schwartz', 'O\'Reilly', 2023],
        ['SQL Performance Explained', 'Markus Winand', 'SQL Performance', 2024],
        ['MongoDB in Action', 'Kyle Banker', 'Manning', 2021],
        ['Redis in Action', 'Josiah L. Carlson', 'Manning', 2023],
        ['Microservices Architecture', 'Sam Newman', 'O\'Reilly', 2024],
    ];

    private static int $bookIndex = 0;

    public function definition(): array
    {
        $data = self::$bookData[self::$bookIndex % count(self::$bookData)];
        self::$bookIndex++;

        return [
            'kode_buku' => 'BK-' . fake()->unique()->numerify('####'),
            'judul' => $data[0],
            'penulis' => $data[1],
            'penerbit' => $data[2],
            'tahun_terbit' => $data[3],
            'isbn' => fake()->unique()->isbn13(),
            'stok_total' => fake()->randomElement([5, 8, 10, 15, 20, 25]),
            'stok_tersedia' => fake()->randomElement([2, 3, 4, 5, 8, 10]),
            'lokasi_rak' => fake()->regexify('[A-Z]{2}-[0-9]{2}'),
        ];
    }
}
