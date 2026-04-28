<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBlogMetaToPostsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts', [
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'author',
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'category',
            ],
            'caption' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'image',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('posts', ['category', 'image', 'caption']);
    }
}
