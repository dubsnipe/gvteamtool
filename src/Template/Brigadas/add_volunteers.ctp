    <!-- File: src/Template/Brigadas/add_volunteers.ctp -->

<?php use Cake\Routing\Router; ?>
<?php $this->assign('title', 'Add Volunteers to team: ' .$brigada->name);?>


<div class="container-2 white section z-depth-1">

    <?php echo $this->Form->create($brigada,['type'=>'post','enctype' => 'multipart/form-data']); ?>
    
    <div class="section">
    
    <?php echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]); ?>
        
    <h2 class="form-title">Participants</h2>
    <?php    
        echo $this->Form->control('voluntarios._ids', array(
            'type' => 'select',
            'multiple' => true,
            'class' => 'selectize',
            'options' => $voluntarios
        ));
    ?>

    <?= $this->Html->link('Add a volunteer', ['controller' => 'Brigadas', 'action' => 'addVolunteersTo', $brigada->id]) ?>
    
    </div> <!-- class="section" -->
    

    <div class="section">
        <div class="row padded-top">
            <?php    
                echo $this->Form->button(__('Save'), ['class' => 'habitat-blue btn-large waves-effect waves-light', 'escape' => false]);
                
                echo $this->Form->button(__('Save and add leader(s)'), ['class' => 'right habitat-blue darken-1 btn-large waves-effect waves-light', 'escape' => false, 'name'=>'addLeaders']);

                echo $this->Form->end();
            ?>
            
        </div>
    </div>
</div>
