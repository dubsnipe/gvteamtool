<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participacione $participacione
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Participacione'), ['action' => 'edit', $participacione->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Participacione'), ['action' => 'delete', $participacione->id], ['confirm' => __('Are you sure you want to delete # {0}?', $participacione->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Participaciones'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Participacione'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Brigadas'), ['controller' => 'Brigadas', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Brigada'), ['controller' => 'Brigadas', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Voluntarios'), ['controller' => 'Voluntarios', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Voluntario'), ['controller' => 'Voluntarios', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="participaciones view large-9 medium-8 columns content">
    <h3><?= h($participacione->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Brigada') ?></th>
            <td><?= $participacione->has('brigada') ? $this->Html->link($participacione->brigada->name, ['controller' => 'Brigadas', 'action' => 'view', $participacione->brigada->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Voluntario') ?></th>
            <td><?= $participacione->has('voluntario') ? $this->Html->link($participacione->voluntario->full_name, ['controller' => 'Voluntarios', 'action' => 'view', $participacione->voluntario->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($participacione->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Lider') ?></th>
            <td><?= $participacione->lider ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
