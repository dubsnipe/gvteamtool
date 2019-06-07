<!-- File: src/Template/Brigadas/add_volunteers_to.ctp -->

<?php use Cake\Routing\Router; ?>
<?php $this->assign('title', 'Add Volunteers to this team: ' .$brigada->name);?>
<?php
    echo $this->Form->create($voluntario,['type'=>'post','enctype' => 'multipart/form-data']);
    
    // Hard code the user for now.
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
?>

<div class="container-2 white section z-depth-1">
    <h1><?= 'Team: ' . $brigada->name ?></h1>
    <p class="center-align">Add a volunteer to a team</p>
    
    <div class="section">

        <h2 class="form-title">Personal Information</h2>
            
        <?php
            echo $this->Form->control('firstName');
            echo $this->Form->control('middleName');
            echo $this->Form->control('lastName');
                        
            
            echo $this->Form->control('gender', [
                'type' => 'select',
                'class' => 'browser-default',
                'empty' => true,
                'options' => ['M' => 'Male', 'F' => 'Female', 'Non-binary' => 'Non-binary']
            ]);
            
            echo $this->Form->control('email', [
                'oninput' => 'check(this.value)'
            ]);
            
            $allowedYear = date("Y") - 16;
            // Brilliant: https://discourse.cakephp.org/t/cakephp3-form-control-with-type-date/3290/2
            $birthDate = 
                $this->Form->control('birth', [
                    'type' => 'text', 
                    // 'class' => 'input-date',
                    // 'minYear' => 1930, 
                    // 'maxYear' => $allowedYear,
                    'empty' => true
                ]);
            $birthControl = str_replace('type="text"', 'type="date"',$birthDate);
            echo $birthControl;
            
            echo $this->Form->control('residenceCountry', [
                'type' => 'select',
                'class' => 'gds-cr crs-country browser-default',
                'label' => 'Country of residence (without abbreviations, e.g. \'United States\'.)',
                'data-region-id' => 'one',
                'country-data-region-id' => 'gds-cr-one',
                'country-data-default-value' =>'United States',
            ]);  
            
            echo $this->Form->control('state', [
                'type' => 'select',
                'id' => 'gds-cr-one',
                'class' => 'browser-default'
            ]);
            
            echo $this->Form->control('city', ['label' => 'City']);

            echo $this->Form->control('address');
            
            echo $this->Form->control('postalCode');        

            echo $this->Form->control('phone', ['label' => 'Phone number']);    
            
            ?>
            
        </div>
    
    <div class="section">
        <h2 class="form-title">Trip logistics information</h2>
        <?php 
            echo $this->Form->control('dietaryRestrictions', [
                'type' => 'select',
                'class' => 'browser-default',
                'empty' => true,
                'options' => ['None', 'Vegetarian', 'No red meat', 'Vegan']
            ]);
            
            echo $this->Form->control('allergies', [
                'class' => 'input-tags',
                'label' => 'Allergies and non-standard food restrictions'
            ]);
            
            echo $this->Form->control('spanishLevel', [
                'label' => 'Level of Spanish',
                'type' => 'select',
                'class' => 'browser-default',
                'empty' => true,
                'options' => ['Basic' => 'Basic', 'Intermediate' => 'Intermediate', 'Conversational' => 'Conversational', 'Native' => 'Native',]
            ]);
            
            echo $this->Form->control('tShirt', [
                'label' => 'T-Shirt Size',
                'type' => 'select',
                'class' => 'browser-default',
                'empty' => true,
                'options' => ['S' => 'S', 'M' => 'M', 'L' => 'L', 'XL' => 'XL', '2XL' => '2XL', '3XL' => '3XL']
            ]);
            
        ?>

    </div>
    
    
    <div class="section">
            
        <h2 class="form-title">Emergency information</h2>
        
        <?php 
        echo $this->Form->control('passportCountry', [
            'type' => 'select',
            'empty' => true,
            'class' => 'gds-cr browser-default',
            'label' => 'Country of passport',
            'country-data-region-id' => 'gds-cr-two',
            'country-data-default-value' =>'United States'
        ]);  
        echo $this->Form->control('healthConsiderations', ['label' => 'Health-related considerations']);
        echo $this->Form->control('emergencyContact', ['label' => 'Emergency contact']);
        echo $this->Form->control('emergencyNumber', ['label' => 'Emergency phone number']);
        ?>
    </div>
    <div class="section">
        <?php
            echo $this->Form->button(__('Save and add new'), ['class' => 'right habitat-blue darken-1 btn-large waves-effect waves-light', 'escape' => false, 'name' => 'addAnother']);
            echo $this->Form->button(__('Save and finish'), ['class' => 'habitat-blue btn-large waves-effect waves-light', 'escape' => false]);
            echo $this->Form->end(); 
        ?>
    </div>        
</div>

<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>

function check() {
    var term = $('#email').serialize();
    console.log(term);
    $('#email').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "<?php echo Router::url(['controller' => 'Voluntarios', 'action' => 'emailAjax']); ?>",
                type: "POST",
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-Token", $('[name="_csrfToken"]').val());
                },
                dataType: 'json',
                data: term,
                success: function(data) {
                    response(data);
                },
            });
        },
        delay: 100,
        minLength: 3,
        close: function() {},
        focus: function(event,ui) {},
        select: function(event, ui) {}
    });
};

<?php $this->Html->scriptEnd(); ?>