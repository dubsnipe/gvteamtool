<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<nav class="habitat-blue darken-1" id="actions-sidebar">
    <ul class="side-nav container-2">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="container"><h1><?= __('Edit My User') ?></h1></div>
<div class="container-2 white z-depth-1 section">
    <?= $this->Form->create($user, ['type'=>'post','enctype' => 'multipart/form-data']) ?>
        <?php
            echo $this->Form->control('first_name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('email');
            echo $this->Form->control('username');
            echo $this->Form->control('current_password', ['type' => 'password']);
            echo $this->Form->control('new_password', ['type' => 'password']);
            echo $this->Form->control('re_new_password', ['type' => 'password']);
            echo $this->Form->control('rol');
        ?>
    <?php echo $this->Form->button(__('Submit'), [
        'class' => 'habitat-blue btn-large waves-effect waves-light', 
        'escape' => false
    ]); ?>
    <?= $this->Form->end() ?>
</div>
