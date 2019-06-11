<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="habitat-blue white-text z-depth-0" id="">
    <ul class="side-nav container">
        <li class="habitat-blue darken-1"><?= $this->Html->link(__('All users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="section container-2 white z-depth-1">
    <h1><?= __('Add User') ?></h1>
    <?= $this->Form->create($user, ['type'=>'post','enctype' => 'multipart/form-data']) ?>
        <?php
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('username');
            echo $this->Form->control('email');
            echo $this->Form->control('rol', [
                'type' => 'select',
                'class' => 'browser-default',
                'empty' => false,
                'options' => ['admin'=>'admin', 'manager'=>'manager', 'user'=>'user']
            ]);
            echo $this->Form->control('password', ['type' => 'password', 'label' => 'Password (6 to 30 characters)']);
            echo $this->Form->control('re_password', ['type' => 'password', 'label' => 'Confirm password']);
        ?>
    <?php echo $this->Form->button(__('Submit'), [
        'class' => 'habitat-blue btn-large waves-effect waves-light', 
        'escape' => false
    ]); ?>
    <?= $this->Form->end() ?>
</div>
