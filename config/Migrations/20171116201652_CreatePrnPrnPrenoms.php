<?php
use Migrations\AbstractMigration;
/**
 * bin/cake bake migration CreatePrnPrnPrenoms prn_id:integer:primary prn_code:string:unique:IDX_PRN_CODE 
 * prn_name:string prn_sex_id:integer prn_dt_created:datetime prn_dt_updated:datetime -p Quinen
 */
class CreatePrnPrnPrenoms extends AbstractMigration
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
        $table = $this->table('prn_prn_prenoms');
        $table->addColumn('prn_id', 'integer', [
            'autoIncrement' => true,
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('prn_code', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('prn_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('prn_sex_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('prn_dt_created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('prn_dt_updated', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addIndex([
            'prn_code',
        ], [
            'name' => 'IDX_PRN_CODE',
            'unique' => true,
        ]);
        $table->addPrimaryKey([
            'prn_id',
        ]);
        $table->create();
    }
}
