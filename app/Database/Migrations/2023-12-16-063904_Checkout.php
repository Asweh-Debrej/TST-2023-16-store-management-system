<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Checkout extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],
            'products' => [
                'type' => 'TEXT',
            ],
        ]);

        $this->forge->addKey('userid', true);
        $this->forge->createTable('checkout');
    }

    public function down()
    {
        $this->forge->dropTable('checkout');
    }
}
