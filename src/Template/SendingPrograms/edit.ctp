<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SendingProgram $sendingProgram
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sendingProgram->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sendingProgram->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sending Programs'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="sendingPrograms form large-9 medium-8 columns content">
    <?= $this->Form->create($sendingProgram) ?>
    <fieldset>
        <legend><?= __('Edit Sending Program') ?></legend>
        <?php
            echo $this->Form->control('title');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
