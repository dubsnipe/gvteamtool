<!-- File: src/Template/Voluntarios/edit.ctp -->

<?php $this->assign('title', 'Edit volunteer: ' .$voluntario->full_name);?>


<?php use Cake\Routing\Router; ?>

<?php echo $this->Form->create($voluntario,['type'=>'post','enctype' => 'multipart/form-data']); ?>
<div class="container-2 white section z-depth-1">
    
    
    <h1>Update Volunteer: <br><span class="subtitle"><?= h($voluntario->full_name) ?></span></h1>
    
    <?php        
        // Hard code the user for now.
        echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    ?>
    <div class="section">
        
        <h2 class="form-title">Personal Information</h2>
        
        <?php
        
        echo $this->Form->control('firstName');
        echo $this->Form->control('middleName');
        echo $this->Form->control('lastName');
        
        echo $this->Form->control('gender', [
            'type' => 'text',
            'empty' => true,
            // 'options' => ['M' => 'Male', 'F' => 'Female', 'Non-binary' => 'Non-binary']
        ]);
        
        echo $this->Form->control('email');
        
        $allowedYear = date("Y") - 16;
        echo $this->Form->control('birth', [
            'type' => 'text',
            'class' => 'thedate',
            'label' => 'Date of birth (format is YYYY-MM-DD, e.g. 1970-12-25 for December 25th, 1970.',
            'minYear' => 1930, 
            'maxYear' => $allowedYear,
            'empty' => true
        ]);

        echo $this->Form->control('residenceCountry', [
            // 'type' => 'select',
            // 'class' => 'gds-cr crs-country',
            'label' => 'Country of residence (without abbreviations, e.g. \'United States\'.)',
            // 'data-region-id' => 'one',
            // 'country-data-region-id' => 'gds-cr-one',
            // 'country-data-default-value' =>'United States',
        ]);  
        
        echo $this->Form->control('state', [
            // 'type' => 'select',
            // 'id' => 'gds-cr-one'
        ]);
        
        echo $this->Form->control('city', ['label' => 'City']);

        echo $this->Form->control('address');
        
        echo $this->Form->control('postalCode');        

        echo $this->Form->control('phone', ['label' => 'Telephone number']);    
        
        ?>
    
    </div>
    
    <div class="section">
        <h2 class="form-title">Trip logistics information</h2>
        <?php 
            echo $this->Form->control('dietaryRestrictions', [
                'label' => 'Dietary Restrictions',
                'type' => 'text',
                // 'empty' => true,
                // 'options' => ['None', 'Vegetarian', 'No red meat', 'Vegan']
            ]);
            
            echo $this->Form->control('allergies', [
                'class' => 'input-tags',
                'label' => 'Allergies and non-standard food restrictions'
            ]);
            
            echo $this->Form->control('spanishLevel', [
                'label' => 'Level of Spanish',
                'type' => 'text',
                'type' => 'text',
                // 'empty' => true,
                'options' => ['None' => 'None', 'Basic' => 'Basic', 'Conversational' => 'Conversational', 'Native' => 'Native']
            ]);
            
            echo $this->Form->control('tShirt', [
                'label' => 'T-Shirt Size',
                'type' => 'text',
                'empty' => true,
                // 'options' => ['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', '2XL' => '2XL', '3XL' => '3XL']
            ]);
        ?>

    </div>
    <div class="section">

        <h2 class="form-title">Emergency information</h2>
        <?php 
        
        echo $this->Form->control('healthNumber', ['label' => 'Passport Number']);
        echo $this->Form->control('passportCountry', [
            // 'type' => 'select',
            'empty' => true,
            // 'class' => 'gds-cr browser-default',
            // 'label' => 'Country of passport',
            // 'country-data-region-id' => 'gds-cr-two',
            // 'country-data-default-value' =>'United States'
        ]);  
        echo $this->Form->control('healthConsiderations', ['label' => 'Health-related considerations']);
        echo $this->Form->control('emergencyContact', ['label' => 'Emergency contact']);
        echo $this->Form->control('emergencyNumber', ['label' => 'Emergency telephone number']);
        ?>
        
    </div>
    
    
    <div class="section">
        
        <h2 class="form-title">Team participations</h2>
        <?php
        
        $a = array_column($voluntario->brigadas, 'id');
        $b = array_column($voluntario->brigadas, 'name');
        $c = array_combine($a,$b);
        
        echo $this->Form->control('brigadas._ids', [
                                            'multiple' => true,
                                            'options' => $c,
        ]);
        
        $this->Html->scriptStart(['block' => 'script']); ?>

        // https://book.cakephp.org/3.0/en/views/helpers/html.html#creating-inline-javascript-blocks
        // Funciona: https://stackoverflow.com/questions/38204883/cakephp3-jquery-autocomplete

        $( function() {
            $('#brigadas-ids').selectize({
                delimiter: ',',
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                // options: [],
                create: false,
                load: function(query, callback) {
                    if (!query.length) return callback();
                    $.ajax({
                        url: '<?php echo Router::url(['controller' => 'Brigadas', 'action' => 'autocomplete']);?>' + '?term=' + query,
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            name: query,
                        },
                        error: function() {
                            callback();
                        },
                        success: function(res) {
                            callback(res);
                            console.log(res);
                        }
                    });
                }
            });
        });
                
        <?php $this->Html->scriptEnd(); ?>
    </div>
    <div class="section">
        <?php
            echo $this->Form->button(__('Save'), ['class' => 'habitat-blue btn-large waves-effect waves-light', 'escape' => false]);
            echo $this->Form->end(); 
        ?>
        
        <?= $this->Form->postLink(
                '<i class="material-icons">delete</i>',
                ['action' => 'delete', $voluntario->id],
                [
                    'class' => 'waves-effect waves-light habitat-brick btn-floating btn-large right', 
                    'title' => 'Delete',
                    'confirm' => 'Do you really want to delete this volunteer and participations?',
                    'escape' => false, 
                ]
        ) ?>
    </div>        
</div>
