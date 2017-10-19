<?php
use Migrations\AbstractMigration;

/*
bin/cake bake migration CreateQnnGrpGroups grp_id:integer:primary grp_code:string:unique:IDX_GRP_CODE grp_name:string grp_dt_created:datetime grp_dt_updated:datetime -p Quinen
*/
class CreateQnnGrpGroups extends AbstractMigration
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
        $table = $this->table('qnn_grp_groups');
        $table->addColumn('grp_id', 'integer', [
            'autoIncrement' => true,
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('grp_code', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('grp_name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('grp_dt_created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('grp_dt_updated', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addIndex([
            'grp_code',
        ], [
            'name' => 'IDX_GRP_CODE',
            'unique' => true,
        ]);
        $table->addPrimaryKey([
            'grp_id',
        ]);
        $table->create();
    }
}
