<?php

use Phinx\Migration\AbstractMigration;

class PaymentLog extends AbstractMigration
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
        $log = $this->table('payment_log');
        $log->addColumn('transaction_id', 'integer')
            ->addColumn('status', 'string')
            ->addColumn('channel', 'string')
            ->addColumn('level', 'string')
            ->addColumn('message', 'text')
            ->addColumn('browser', 'string')
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->create();
    }
}
