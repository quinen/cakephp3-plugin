<?php
namespace Quinen\Model\Entity;

use Cake\ORM\Entity;

/**
 * QnnGrpGroup Entity
 *
 * @property int $grp_id
 * @property string $grp_code
 * @property string $grp_name
 * @property \Cake\I18n\FrozenTime $grp_dt_created
 * @property \Cake\I18n\FrozenTime $grp_dt_updated
 *
 * @property \Quinen\Model\Entity\Grp $grp
 */
class QnnGrpGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'grp_code' => true,
        'grp_name' => true,
        'grp_dt_created' => true,
        'grp_dt_updated' => true,
    ];
}
