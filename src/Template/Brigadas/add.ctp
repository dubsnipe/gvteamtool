<!-- File: src/Template/Brigadas/add.ctp -->

<?php use Cake\Routing\Router; ?>

<?php $this->assign('title', 'New Team');?>

<div class="container-2 white section z-depth-1">
    
    <?php
        echo $this->Form->create($brigada,['type'=>'file', 'enctype' => 'multipart/form-data']); 
        // Hard code the user for now.
        echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    ?>
 
<h1>Add a team</h1>
    <div class="section">
        <?php echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
        echo $this->Form->control('name');
        echo $this->Form->control('gvCode');
        // https://stackoverflow.com/questions/30947323/cakephp-3-0-how-to-populate-a-select-field-with-values-instead-of-id/30951861
        
        echo $this->Form->control('team_type', [
            'type' => 'select',
            'class' => 'select-beast',
            'multiple' => false,
            'options' => $typeChoices,
            'empty' => true
        ]);
        
        // https://discourse.cakephp.org/t/cakephp3-form-control-with-type-date/3290/2
        $arrivalDate = 
            $this->Form->control('arrival', [
                'type' => 'text', 
            ]);
        $arrivalControl = str_replace('type="text"', 'type="date"',$arrivalDate);
        echo $arrivalControl;

        $departureDate = 
            $this->Form->control('departure', [
                'type' => 'text', 
            ]);
        $departureControl = str_replace('type="text"', 'type="date"',$departureDate);
        echo $departureControl;


        echo $this->Form->control('region', [
            'type' => 'select',
            'class' => 'select-vanilla',
            'multiple' => false,
            'options' => $regionChoices,
            'empty' => true,
            // 'create' => false,
        ]);

        echo $this->Form->control('project', [
            'type' => 'select',
            'class' => 'select-vanilla',
            'multiple' => false,
            'options' => $projectChoices,
            'empty' => true,
            'create' => false,
        ]);
        
        // Esta función requiere construir una tabla de las opciones más adelante.
        // echo $this->Form->control('officer');
        echo $this->Form->control('officer', [
            'type' => 'select',
            'class' => 'select-vanilla',
            'multiple' => false,
            'options' => $officerChoices,
            'empty' => true,
            // 'create' => false,
        ]);
        
        // Esta función requiere construir una tabla de las opciones más adelante.
        // echo $this->Form->control('translator');
        echo $this->Form->control('translator', [
            'type' => 'select',
            'class' => 'select-vanilla',
            'multiple' => false,
            'options' => $translatorChoices,
            'empty' => true
        ]);
            
        // Esta función requiere construir una tabla de las opciones más adelante.
        // $sendingProgramChoices = array('', 'HFHI', 'HFH Canada');
        echo $this->Form->control('sending_program');
        ?>
        
        
        <div class="">
            <?php
                    echo $this->Form->control('funds_budgeted', [
                        'type' => 'number',
                        'class' => '',
                        'min' => '0',
                        'step'=> '.01'
                    ]); ?>

            <?php echo $this->Form->control('funds_received', [
                'type' => 'number',
                'class' => '',
                'min' => '0',
                'step'=> '.01'
                ]);
            ?>
        </div>
        
        
        <?php
        echo $this->Form->control('comments', ['type' => 'textarea', 'class' => 'materialize-textarea']);
        
        // Futuro: Cambiar por Ajax
        // 2018-06-21 - Se comentó para dar espacio a hacer la modificación en otra página específica para esto.
        // echo $this->Form->control('voluntarios._ids', array('class' => 'selectize'));
        
        echo $this->Form->control('tag_string', 
            [
                'type' => 'text', 
                'placeholder' => 'Separate tags by comma. E.g. affiliate, first.time, donors',
                'label' => 'Tags'
            ]);

    ?>
    
    <div class="file-field input-field">
        <div class="btn btn-flat grey lighten-2 white-text">
            <span>Photo</span>
            <?php
                echo $this->Form->control('photo', [
                    'type' => 'file',
                    'label' => '',
                    'required' => false,
                    ]);
            ?>
        </div>
        <div class="file-path-wrapper">
            <input class="file-path" type="text">
        </div>
    </div>
    
    </div>
    
    <div class="section">
        <?php
            echo $this->Form->button(__('Save'), ['class' => 'habitat-blue btn-large waves-effect waves-light', 'escape' => false]);

            echo $this->Form->button(__('Save and add volunteers'), ['class' => 'right habitat-blue darken-1 btn-large waves-effect waves-light', 'escape' => false, 'name'=>'addVolunteers']);
            echo $this->Form->end(); 
        ?>
    </div>

</div>

<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>
$('#tag-string').selectize({
        valueField: 'title',
        labelField: 'title',
        searchField: 'title',
        delimiter: ',',
        persist: false,
        create: true,
        load: function( request, callback ) {
            var term = {title:request};
            $.ajax({
                url: '<?php echo Router::url(['controller' => 'Tags', 'action' => 'tagAjax']); ?>',
                type: 'POST',
                error: function() {
                    callback();
                },
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-Token", $('[name="_csrfToken"]').val());
                },
                data: term,
                dataType: "json",
                success: function(result) {
                    console.log(result);
                    callback(result);
                }
            });
        },
    });
<?php $this->Html->scriptEnd(); ?>