    <!-- File: src/Template/Brigadas/add_volunteers.ctp -->

<?php use Cake\Routing\Router; ?>
<?php $this->assign('title', 'Add Volunteers to team: ' .$brigada->name);?>


<div class="container-2 white section z-depth-1">

    <?php echo $this->Form->create($brigada,['type'=>'post','enctype' => 'multipart/form-data']); ?>
    
    <div class="section">
    
    <?php echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]); ?>
        
    
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
    <?php } else { ?>
        Add volunteers first and return.
        <div>
        <?php echo $this->Html->link(
            'Add volunteers',
            ['controller' => 'Voluntarios', 'action' => 'addVolunteers', '_full' => true],
            ['class' => 'button', 'target' => '_blank']
        ); ?>
        </div>
    <?php } ?>
    
    </div> <!-- class="section" -->
    

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