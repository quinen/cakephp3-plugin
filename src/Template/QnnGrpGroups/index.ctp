

<table class="table table-striped" cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('grp_id'); ?></th>
            <th><?= $this->Paginator->sort('grp_code'); ?></th>
            <th><?= $this->Paginator->sort('grp_name'); ?></th>
            <th><?= $this->Paginator->sort('grp_dt_created'); ?></th>
            <th><?= $this->Paginator->sort('grp_dt_updated'); ?></th>
            <th class="actions"><?= __('Actions'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($qnnGrpGroups as $qnnGrpGroup): ?>
        <tr>
            <td><?= $this->Number->format($qnnGrpGroup->grp_id) ?></td>
            <td><?= h($qnnGrpGroup->grp_code) ?></td>
            <td><?= h($qnnGrpGroup->grp_name) ?></td>
            <td><?= h($qnnGrpGroup->grp_dt_created) ?></td>
            <td><?= h($qnnGrpGroup->grp_dt_updated) ?></td>
            <td class="actions">
                <?= $this->Html->link('', ['action' => 'view', $qnnGrpGroup->grp_id], ['title' => __('View'), 'class' => 'btn btn-default glyphicon glyphicon-eye-open']) ?>
                <?= $this->Html->link('', ['action' => 'edit', $qnnGrpGroup->grp_id], ['title' => __('Edit'), 'class' => 'btn btn-default glyphicon glyphicon-pencil']) ?>
                <?= $this->Form->postLink('', ['action' => 'delete', $qnnGrpGroup->grp_id], ['confirm' => __('Are you sure you want to delete # {0}?', $qnnGrpGroup->grp_id), 'title' => __('Delete'), 'class' => 'btn btn-default glyphicon glyphicon-trash']) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '']) ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
    </ul>
    <p><?= $this->Paginator->counter() ?></p>
</div>
