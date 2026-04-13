<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostsTable extends Migration
{
    public function up()
    {
          $this->forge->addField([
            'id' => [
                'type'           => 'SERIAL',
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'author' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'John Doe',
            ],
            'content' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'default'    => 'draft',
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('posts', true);

        $this->db->query("
            ALTER TABLE posts
            ADD CONSTRAINT posts_status_check
            CHECK (status IN ('published', 'draft'))
        ");
    }

    public function down()
    {
        // menghapus tabel posts
        $this->forge->dropTable('posts');
    }
}
