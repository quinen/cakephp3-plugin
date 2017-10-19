<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');


$this->start('tb_actions');
?>
<li><?= $this->Html->link(__('Edit Qnn Grp Group'), ['action' => 'edit', $qnnGrpGroup->grp_id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Qnn Grp Group'), ['action' => 'delete', $qnnGrpGroup->grp_id], ['confirm' => __('Are you sure you want to delete # {0}?', $qnnGrpGroup->grp_id)]) ?> </li>
<li><?= $this->Html->link(__('List Qnn Grp Groups'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Qnn Grp Group'), ['action' => 'add']) ?> </li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
<li><?= $this->Html->link(__('Edit Qnn Grp Group'), ['action' => 'edit', $qnnGrpGroup->grp_id]) ?> </li>
<li><?= $this->Form->postLink(__('Delete Qnn Grp Group'), ['action' => 'delete', $qnnGrpGroup->grp_id], ['confirm' => __('Are you sure you want to delete # {0}?', $qnnGrpGroup->grp_id)]) ?> </li>
<li><?= $this->Html->link(__('List Qnn Grp Groups'), ['action' => 'index']) ?> </li>
<li><?= $this->Html->link(__('New Qnn Grp Group'), ['action' => 'add']) ?> </li>
</ul>
<?php
$this->end();
?>
<div class="panel panel-default">
    <!-- Panel header -->
    <div class="panel-heading">
        <h3 class="panel-title"><?= h($qnnGrpGroup->grp_name) ?></h3>
    </div>
    <table class="table table-striped" cellpadding="0" cellspacing="0">
        <tr>
            <td><?= __('Grp Code') ?></td>
            <td><?= h($qnnGrpGroup->grp_code) ?></td>
        </tr>
        <tr>
            <td><?= __('Grp Name') ?></td>
            <td><?= h($qnnGrpGroup->grp_name) ?></td>
        </tr>
        <tr>
            <td><?= __('Grp Id') ?></td>
            <td><?= $this->Number->format($qnnGrpGroup->grp_id) ?></td>
        </tr>
        <tr>
            <td><?= __('Grp Dt Created') ?></td>
            <td><?= h($qnnGrpGroup->grp_dt_created) ?></td>
        </tr>
        <tr>
            <td><?= __('Grp Dt Updated') ?></td>
            <td><?= h($qnnGrpGroup->grp_dt_updated) ?></td>
        </tr>
    </table>
</div>

