<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="habitat-blue white-text z-depth-0" id="">
    <ul class="side-nav container">
        <li class="habitat-blue darken-1"><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li class="habitat-blue darken-1"><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li class="habitat-blue darken-1"><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li class="habitat-blue darken-1"><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
    </ul>
</nav>

<div class="section container container-2">
<h1>User ID: <?= h($user->id) ?></h1>
    <table class="z-depth-1 white section">
        <tr>
            <th class="white"><?= __('First Name') ?></th>
            <td><?= h($user->first_name) ?></td>
        </tr>
        <tr>
            <th class="white"><?= __('Last Name') ?></th>
            <td><?= h($user->last_name) ?></td>
        </tr>
        <tr>
            <th class="white"><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th class="white"><?= __('Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th class="white"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th class="white"><?= __('Created') ?></th>
            <td><?= h($user->created) ?></td>
        </tr>
        <tr>
            <th class="white"><?= __('Modified') ?></th>
            <td><?= h($user->modified) ?></td>
        </tr>
        <tr>
            <th class="white"><?= __('Role') ?></th>
            <td><?= h($user->rol) ?></td>
        </tr>
    </table>
</div>
