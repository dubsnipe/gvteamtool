    <!-- File: src/Template/Brigadas/edit.ctp -->

<?php use Cake\Routing\Router; ?>
<?php $this->assign('title', 'Edit team: ' .$brigada->name);?>


<div class="container-2 white section z-depth-1">

    <?php echo $this->Form->create($brigada,['type'=>'post','enctype' => 'multipart/form-data']); ?>
    
    <h1>Update Team: <br><span class="subtitle"><?= h($brigada->name) ?></span></h1>
    
    <div class="section">
        <div class="divider"></div>
        
        <div id="team-status" class="padded-top center-align grey lighten-5">
            <div class="switch status">
                <label>
                    Cancelled
                    <?php echo $this->Form->control('status',[
                        'label' => false,
                        'type' => 'checkbox',
                        'default'=>'1',
                        'templates' => ['inputContainer' => '{{content}}'],
                        ]
                    ); ?>
                    <span class="lever"></span>
                    Approved
                </label>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <h2 class="form-title">Team Information</h2>
        <?php echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]); ?>
        

    <?php    
        echo $this->Form->control('name');
        echo $this->Form->control('gvCode');
        // https://stackoverflow.com/questions/30947323/cakephp-3-0-how-to-populate-a-select-field-with-values-instead-of-id/30951861
        echo $this->Form->control('team_type', [
            'type' => 'text',
            // 'class' => 'select-beast',
            // 'options' => $typeChoices,
            'empty' => true,
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
            'empty' => true
        ]);

        echo $this->Form->control('project', [
            'type' => 'select',
            'class' => 'select-vanilla',
            'multiple' => false,
            'options' => $projectChoices,
            'empty' => true
        ]);
    
        echo $this->Form->control('officer', [
            'type' => 'select',
            'class' => 'select-vanilla',
            'multiple' => false,
            'options' => $officerChoices,
            'empty' => true
        ]);
    
        echo $this->Form->control('translator', [
            'type' => 'select',
            'class' => 'select-vanilla',
            'multiple' => false,
            'options' => $translatorChoices,
            'empty' => true
        ]);
            
        echo $this->Form->control('sending_program');
    ?>
        <div class="row">
            <div class="col s6">
            <?php
                echo $this->Form->control('funds_budgeted', [
                    'type' => 'number',
                    'class' => '',
                    'min' => '0',
                    'step'=> '.01'
                ]); ?>
            </div>
            <div class="col s6">    
                <?php echo $this->Form->control('funds_received', [
                    'type' => 'number',
                    'class' => '',
                    'min' => '0',
                    'step'=> '.01'
                ]);
            ?>
            </div>
        </div>
    <?php
        echo $this->Form->control('comments', ['type' => 'textarea', 'class' => 'materialize-textarea']);    
        
        // Futuro: Cambiar por Ajax
        echo $this->Form->control('tag_string', [
                'placeholder' => 'Separate tags by comma. E.g. affiliate, first.time, donors',
            ]); ?>

        <h2 class="form-title">Team Photo</h2>
        <?php if ($brigada->photo){ ?>
            <div class="edit-photo">
                <?php $imgUrl = '../webroot/files/Brigadas/photo' . $brigada->photo_dir . '/' . $brigada->photo; ?>
                <?php echo $this->Html->image($imgUrl, ['class' => 'materialboxed', ]); ?>
                
                <!-- Link para borrar foto -->

                
            </div>
        <?php }; ?> 
        
        <div class="file-field input-field">
            <div class="btn habitat-grey">
                <span>Photo</span>
                <?php
                    echo $this->Form->control('photo', [
                        'templates' => [
                            
                        ],
                        'type' => 'file',
                        'label' => '',
                        'required' => false,
                        ]);
                ?>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path" type="text" value="<?php echo $brigada->photo ?>">
            </div>
        </div>
        

        
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
    
    <?php 
    // https://github.com/cakephp/cakephp/issues/3995
    if (isset($brigada->voluntarios) && count($brigada->voluntarios) > 0){ ?> 

        <h2 class="form-title">Team Leaders</h2>

        <table class="highlight">
            <?php $all_vol = $brigada->voluntarios;
            foreach($all_vol as $key=>$voluntario){ ?>
            <tr>
                <td><?php echo ($voluntario->full_name); ?></td>
                <td>
                    <?php echo $this->Form->control('voluntarios.'.$key.'.id', ['hidden' => false]); ?>
                    <div class="switch center-align">
                    <label>
                    <?php
                        echo $this->Form->control('voluntarios.'.$key.'._joinData.lider', [
                            // https://stackoverflow.com/questions/29686111/cakephp-3-0-change-or-remove-wrapping-div-on-input-form
                            'label' => $voluntario->full_name,
                            'default'=>'0',
                            'type' => 'checkbox',
                            'templates' => ['inputContainer' => '{{content}}'],
                            'label' => false,
                        ]); ?>
                        <span class="lever"></span>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </table>
        
    <?php } ?>
    
    </div>

    <div class="section">
        <div class="row padded-top">
            <?php    
                echo $this->Form->button(__('Save'), ['class' => 'habitat-blue btn-large waves-effect waves-light', 'escape' => false]);
                
                echo $this->Form->end();
            ?>
            
            <?= $this->Form->postLink(
                '<i class="material-icons">delete</i>',
                ['action' => 'delete', $brigada->id],
                [
                    'class' => 'waves-effect waves-light habitat-brick btn-floating btn-large right', 
                    'title' => 'Delete',
                    'confirm' => 'Do you really want to delete this team?',
                    'escape' => false, 
                ]
            ) ?>
        </div>
    </div>
</div>

<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>
// $('#voluntarios-ids').selectize({
        // valueField: 'id',
        // nameField: 'full_name',
        // labelField: 'full_name',
        // searchField: 'full_name',
        // delimiter: ',',
        // persist: false,
        // create: true,
        // load: function( request, callback ) {
            // var term = {full_name:request};
            // $.ajax({
                // url: '<?php echo Router::url(['controller' => 'Voluntarios', 'action' => 'voluntariosAjax']); ?>',
                // type: 'POST',
                // error: function() {
                    // callback();
                // },
                // beforeSend: function(xhr){
                    // xhr.setRequestHeader("X-CSRF-Token", $('[name="_csrfToken"]').val());
                // },
                // data: term,
                // dataType: "json",
                // success: function(result) {
                    // callback(result);
                // }
            // });
        // },
    // });
    
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
                    callback(result);
                }
            });
        },
    });
<?php $this->Html->scriptEnd(); ?>