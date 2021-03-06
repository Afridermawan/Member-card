<?php

use Phinx\Migration\AbstractMigration;

class Event extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('events');
        $table->addColumn('name', 'string')
              ->addColumn('slug', 'string')
              ->addColumn('description', 'text', ['null' => true])
              ->addColumn('image', 'string', ['null' => true])
              ->addColumn('biaya_pendaftaran', 'string', ['null' => true])
              ->addColumn('start_date', 'datetime')
              ->addColumn('deleted', 'integer', ['default' => 0])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP','update' => 'CURRENT_TIMESTAMP'])
              ->addIndex(['name'])
              ->create();
    }
}
