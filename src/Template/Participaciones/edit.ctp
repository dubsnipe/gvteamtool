<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Participacione $participacione
 */
?>
<!-- <nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $participacione->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $participacione->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Participaciones'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Brigadas'), ['controller' => 'Brigadas', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Brigada'), ['controller' => 'Brigadas', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Voluntarios'), ['controller' => 'Voluntarios', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Voluntario'), ['controller' => 'Voluntarios', 'action' => 'add']) ?></li>
    </ul>
</nav> -->
<!-- <div class="participaciones form large-9 medium-8 columns content"> -->
<div class="participaciones">
    <h1><?= h($brigada->name) ?></h1>
    
    <?= $this->Form->create($participacione) ?>
    <fieldset>
        <legend><?= __('Edit Participacione') ?></legend>
        <table>
        <?php foreach ($brigada->voluntarios as $voluntario): ?>
            <!-- // echo $this->Form->control('brigada_id', ['options' => $brigadas]); -->
            <tr>
            <td><?php echo $voluntario->full_name;?></td>
            <td><?php echo $this->Form->control('lider');?></td>
            </tr>
            
            
        <?php endforeach;        ?>
        </table>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
