<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Translator $translator
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Translator'), ['action' => 'edit', $translator->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Translator'), ['action' => 'delete', $translator->id], ['confirm' => __('Are you sure you want to delete # {0}?', $translator->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Translators'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Translator'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="translators view large-9 medium-8 columns content">
    <h3><?= h($translator->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($translator->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($translator->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($translator->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($translator->modified) ?></td>
        </tr>
    </table>
</div>
