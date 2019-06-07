<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participacione[]|\Cake\Collection\CollectionInterface $participaciones
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Participacione'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Brigadas'), ['controller' => 'Brigadas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Brigada'), ['controller' => 'Brigadas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Voluntarios'), ['controller' => 'Voluntarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Voluntario'), ['controller' => 'Voluntarios', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="participaciones index large-9 medium-8 columns content">
    <h3><?= __('Participaciones') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('brigada_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('voluntario_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lider') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participaciones as $participacione): ?>
            <tr>
                <td><?= $this->Number->format($participacione->id) ?></td>
                <td><?= $participacione->has('brigada') ? $this->Html->link($participacione->brigada->name, ['controller' => 'Brigadas', 'action' => 'view', $participacione->brigada->id]) : '' ?></td>
                <td><?= $participacione->has('voluntario') ? $this->Html->link($participacione->voluntario->full_name, ['controller' => 'Voluntarios', 'action' => 'view', $participacione->voluntario->id]) : '' ?></td>
                <td><?= h($participacione->lider) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $participacione->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $participacione->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $participacione->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participacione->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
