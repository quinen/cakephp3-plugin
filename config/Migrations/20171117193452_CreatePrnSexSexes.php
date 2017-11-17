<?php
use Migrations\AbstractMigration;

class CreatePrnSexSexes extends AbstractMigration
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
        $table = $this->table('prn_sex_sexes');
        $table->addColumn('sex_id', 'integer', [
            'autoIncrement' => true,
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('sex_code', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('sex_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addIndex([
            'sex_code',
        ], [
            'name' => 'IDX_PRN_CODE',
            'unique' => true,
        ]);
        $table->addPrimaryKey([
            'sex_id',
        ]);
        $table->create();
    }
}
