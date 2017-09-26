<?php
use Migrations\AbstractMigration;

class CreateQnnUsrUsers extends AbstractMigration
{

    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     * @return void
     */
    public function change()
    {
        $table = $this->table('qnn_usr_users');
        $table->addColumn('usr_id', 'integer', [
            'autoIncrement' => true,
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('usr_login', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('usr_password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('usr_email', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('usr_dt_created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('usr_dt_updated', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addIndex([
            'usr_login',
        ], [
            'name' => 'IDX',
            'unique' => true,
        ]);
        $table->addPrimaryKey([
            'usr_id',
        ]);
        $table->create();
    }
}
