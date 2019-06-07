<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participacione $participacione
 */
?>
<!-- <nav class="large-3 medium-4 columns" id="actions-sidebar"> -->
    <!-- <ul class="side-nav"> -->
        <!-- <li class="heading"><?= __('Actions') ?></li> -->
        <!-- <li><?= $this->Html->link(__('List Participaciones'), ['action' => 'index']) ?></li> -->
        <!-- <li><?= $this->Html->link(__('List Brigadas'), ['controller' => 'Brigadas', 'action' => 'index']) ?></li> -->
        <!-- <li><?= $this->Html->link(__('New Brigada'), ['controller' => 'Brigadas', 'action' => 'add']) ?></li> -->
        <!-- <li><?= $this->Html->link(__('List Voluntarios'), ['controller' => 'Voluntarios', 'action' => 'index']) ?></li> -->
        <!-- <li><?= $this->Html->link(__('New Voluntario'), ['controller' => 'Voluntarios', 'action' => 'add']) ?></li> -->
    <!-- </ul> -->
<!-- </nav> -->
<div class="participaciones">
    <?= $this->Form->create($participacione) ?>
    <fieldset>
        <legend><?= __('Add Participacione') ?></legend>
        <?php
            echo $participacione->brigada_id;
            
            echo $this->Form->control('brigada_id', ['options' => $brigadas]);
        ?>
        <?php
            echo $this->Form->control('voluntario_id', ['options' => $voluntarios]);
            echo $this->Form->control('lider');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
