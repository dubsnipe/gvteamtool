<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Officer $officer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $officer->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $officer->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Officers'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="officers form large-9 medium-8 columns content">
    <?= $this->Form->create($officer) ?>
    <fieldset>
        <legend><?= __('Edit Officer') ?></legend>
        <?php
            echo $this->Form->control('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
