<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use function url_title;

class PostSeeder extends Seeder
{
    public function run()
    {
        helper('url');

        // membuat data
        $posts_data = [
            [
                'title' => 'Mulai Nyobain
Codeigniter',
                'author' => 'codeigniter-starter',
                'content' => 'Lorem ipsum dolor sit
amet, consectetur adipiscing elit, sed do eiusmod tempor
incididunt ut labore et dolore aliqua.',
            ],
          
        ];

        foreach ($posts_data as $data) {
            $data['slug'] = url_title($data['title'], '-', true);

            // insert semua data ke tabel
            $this->db->table('posts')->insert($data);
        }
    }
}
