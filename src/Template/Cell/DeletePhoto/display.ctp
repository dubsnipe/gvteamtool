<div class="container-2">
    <?php
    // echo $id;
    if ($id > 0){
        // https://stackoverflow.com/questions/15071975/how-can-i-delete-files-with-cakephp-and-ajax
        echo $this->Form->postLink(
            'Delete',
            ['action' => 'deletePhoto', $id],
            [
                'class' => 'waves-effect waves-light habitat-blue white-text btn-floating btn-large right z-depth-3', 
                'style' => 'position: relative; top: -80px;',
                'title' => 'Remove',
                'confirm' => 'Do you really want to delete this photo?',
                'escape' => false, 
            ]
        );
    };
    ?>
</div>