<div class="container">
    <h1>Login</h1>

    <div class="container-2 section white z-depth-1">
        <?= $this->Form->create() ?>
            <?= $this->Form->control('email') ?>
            <?= $this->Form->control('password') ?>
            
            <div class="padded-top center-align">
            <div class="switch">
                <label>
                    <p>Keep me logged in</p>
                    <?php echo $this->Form->control('xx',[
                        'label' => false,
                        'type' => 'checkbox',
                        'default'=>'1',
                        'templates' => ['inputContainer' => '{{content}}'],
                        ]
                    ); ?>
                    <span class="lever"></span>
                <label>
            </div>
        </div>
            
            <div class="center-align section"><?= $this->Form->button(__('Login'), ['class' => 'btn waves-effect waves-light habitat-blue']) ?></div>
        <?= $this->Form->end() ?>
    </div>
    
</div>