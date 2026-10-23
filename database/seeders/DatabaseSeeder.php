<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (Post::count() === 0) {
            Post::create([
                'title' => 'Cyberpunk',
                'content' => 'Siberpunk ya da Siber çılgınlık, "yüksek teknoloji, düşük yaşam" şeklinde özetlenen bir dünya şekli çizen bilimkurgu alt türüdür. Siberpunk, bilim ve teknolojinin çok ilerlediği ancak insanların büyük kısmının yaşam kalitesinin çok düşük olduğu, bozulduğu veya toplumsal düzenin radikal bir şekilde değiştiği bir dünya tasavvurudur.',
            ]);
        }
    }
}
