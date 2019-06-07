<!-- File: src/Template/Brigadas/teamleaders.ctp -->

<h1>Edit Team Leaders</h1>
<div class="panel callout radius">

<?php
    echo $this->Form->create($brigada,['type'=>'post','enctype' => 'multipart/form-data']);

// https://github.com/cakephp/cakephp/issues/3995
for ($i = 0; $i < count($brigada->voluntarios); ++$i):
    $voluntario = $brigada->voluntarios[$i];
    echo $this->Form->control(
        'voluntarios.' . $i . '._joinData.lider',
            [   
                'label' => $voluntario->full_name,
            ]
        );
        endfor
        
    // echo $this->Form->checkbox('voluntarios.0._joinData.lider', ['options' => [true, false]);
    // echo $this->Form->control('voluntarios.1._joinData.lider'); ?>

</div>
<?php    
    echo $this->Form->button(__('Save'));
    echo $this->Form->end();
?>


