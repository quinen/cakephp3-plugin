<?php
namespace Quinen\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QnnGrpGroupsFixture
 *
 */
class QnnGrpGroupsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'grp_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'grp_code' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'grp_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'grp_dt_created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'grp_dt_updated' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['grp_id'], 'length' => []],
            'IDX_GRP_CODE' => ['type' => 'unique', 'columns' => ['grp_code'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'grp_id' => 1,
            'grp_code' => 'Lorem ipsum dolor sit amet',
            'grp_name' => 'Lorem ipsum dolor sit amet',
            'grp_dt_created' => '2017-10-15 16:59:01',
            'grp_dt_updated' => '2017-10-15 16:59:01'
        ],
    ];
}
