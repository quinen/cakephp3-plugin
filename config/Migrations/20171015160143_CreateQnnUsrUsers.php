<?php
use Migrations\AbstractMigration;
/*
    generated with the command line :
    bin/cake bake migration CreateQnnUsrUsers usr_id:integer:primary usr_code:string:unique:IDX_USR_CODE usr_login:string usr_password:string usr_dt_created:datetime usr_dt_updated:datetime -p Quinen
*/
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
        $table->addColumn('usr_code', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('usr_grp_id', 'integer', [
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
        $table->addColumn('usr_dt_created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('usr_dt_updated', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addIndex([
            'usr_code',
        ], [
            'name' => 'IDX_USR_CODE',
            'unique' => true,
        ]);
        $table->addPrimaryKey([
            'usr_id',
        ]);
        $table->create();
    }
}
