<!-- File: src/Template/Brigadas/edit.ctp -->

<h1>Update Team Members</h1>
<?php echo $this->Form->create($brigada2); ?>
<div class="panel callout radius">
    <?php echo ($brigada2) ?>
    <?php // echo $this->Form->control('lider'); ?>
    


</div>
<?php    
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>
