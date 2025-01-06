<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class commentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::create([
            'content' => 'Baksonya sangat enak, harus dicoba',
            'user_id' => '4',
            'business_id' => '2',
            'parent_id' => NULL,
        ]);

        Comment::create([
            'content' => 'Setuju bangets',
            'user_id' => '3',
            'business_id' => '2',
            'parent_id' => '1',
        ]);

        Comment::create([
            'content' => 'Kuahnya gurih banget, bikin nagih!',
            'user_id' => '5',
            'business_id' => '2',
            'parent_id' => NULL,
        ]);

        Comment::create([
            'content' => 'Benar banget, apalagi kalau ditambah sambal. Mantap!',
            'user_id' => '6',
            'business_id' => '2',
            'parent_id' => '3',
        ]);

        Comment::create([
            'content' => 'Bakso uratnya gede dan kenyal, cocok buat penggemar daging.',
            'user_id' => '7',
            'business_id' => '2',
            'parent_id' => NULL,
        ]);

        Comment::create([
            'content' => 'Iya, tekstur uratnya itu yang bikin beda sama bakso lainnya.',
            'user_id' => '8',
            'business_id' => '2',
            'parent_id' => '5',
        ]);

        Comment::create([
            'content' => 'Harga juga worth it banget untuk kualitas rasa seperti ini.',
            'user_id' => '9',
            'business_id' => '2',
            'parent_id' => NULL,
        ]);

        // Comment::create([
        //     'content' => 'Setuju! Harga pas di kantong, rasanya premium.',
        //     'user_id' => '10',
        //     'business_id' => '2',
        //     'parent_id' => '7',
        // ]);
    }
}
