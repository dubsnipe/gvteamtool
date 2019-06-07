<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SendingProgram $sendingProgram
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sending Program'), ['action' => 'edit', $sendingProgram->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sending Program'), ['action' => 'delete', $sendingProgram->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sendingProgram->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Sending Programs'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sending Program'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sendingPrograms view large-9 medium-8 columns content">
    <h3><?= h($sendingProgram->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($sendingProgram->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($sendingProgram->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($sendingProgram->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($sendingProgram->modified) ?></td>
        </tr>
    </table>
</div>
