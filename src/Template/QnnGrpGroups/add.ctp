<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php
$this->extend('../Layout/TwitterBootstrap/dashboard');

$this->start('tb_actions');
?>
    <li><?= $this->Html->link(__('List Qnn Grp Groups'), ['action' => 'index']) ?></li>
<?php
$this->end();

$this->start('tb_sidebar');
?>
<ul class="nav nav-sidebar">
    <li><?= $this->Html->link(__('List Qnn Grp Groups'), ['action' => 'index']) ?></li>
</ul>
<?php
$this->end();
?>
<?= $this->Form->create($qnnGrpGroup); ?>
<fieldset>
    <legend><?= __('Add {0}', ['Qnn Grp Group']) ?></legend>
    <?php
    echo $this->Form->control('grp_code');
    echo $this->Form->control('grp_name');
    echo $this->Form->control('grp_dt_created');
    echo $this->Form->control('grp_dt_updated');
    ?>
</fieldset>
<?= $this->Form->button(__("Add")); ?>
<?= $this->Form->end() ?>
