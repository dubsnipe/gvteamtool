<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>


<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= 'GV Calendar - '. $this->fetch('title', 'GV Calendar') ?></title>
    <?= $this->Html->meta('icon') ?>

    <?php
    // Base CakePHP CSS
    // $this->Html->css('base.css');
    // $this->Html->css('style.css');
    // $this->fetch('meta');
    // $this->fetch('css');
     ?>

    
    <!-- Materialize 1.0.0 -->
    <!-- Compiled and minified CSS --><!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/css/materialize.min.css">-->
    <?= $this->Html->css('materialize.min.css') ?>
    <?= $this->Html->css('style-custom.css') ?>
    
    <?= $this->fetch('styles') ?>
    
    <script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous"></script>

      <script
      src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
      integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
      crossorigin="anonymous"></script>    
    <?php // echo $this->Html->css('//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css'); ?>
    <?php echo $this->Html->css('//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'); ?>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-rc.2/js/materialize.min.js"></script>-->
    
    <?php echo $this->Html->script('materialize.min.js'); ?>
    <?php echo $this->Html->script('init.js'); ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/js/standalone/selectize.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.4/css/selectize.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://unpkg.com/ionicons@4.4.2/dist/css/ionicons.min.css" rel="stylesheet">

    <?= $this->fetch('script') ?>

    
</head>
<body class="blue-grey lighten-5">
<header>
    <ul id="dropdown1" class="dropdown-content">
        <li>
            <?php echo $this->Html->link('Profile', [
                'controller' => 'Users',
                'action' => 'view/' . $this->request->session()->read('Auth.User.id'),
            ]); ?>
        </li>
        <li>
            <?php echo $this->Html->link('Edit', [
                'controller' => 'Users',
                'action' => 'edit/',
            ]); ?>
        </li>
        <li>
            <?php echo $this->Html->link('Logout', [
                'controller' => 'Users',
                'action' => 'logout',
            ]); ?>
        </li>
    </ul>
    
    <nav class="top-bar expanded habitat-blue z-depth-0 white-text" data-topbar role="navigation">
    <div class="nav-wrapper container">
        <?php 
        echo $this->Html->link( 
            $this->Html->image('logo.svg', ['alt' => 'logo', 'class' => 'brand-logo']), 
            ['controller' => 'Stats', 'action' => 'index'],
            ['escape' => false]
        ); 
        ?>
        
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons icon ion-md-menu"></i></a>
        
        <?php if ($this->request->getSession()->read('Auth.User.username')) { ?>
            
        
            <ul class="right hide-on-med-and-down">
                <?php $username = $this->request->getSession()->read('Auth.User.username'); ?>
                <li>
                    <?php echo $this->Html->link('Teams', [
                        'controller' => 'Brigadas',
                        'action' => 'index',
                    ]); ?>
                </li>
                <li>
                    <?php echo $this->Html->link('Volunteers', [
                        'controller' => 'Voluntarios',
                        'action' => 'index',
                    ]); ?>
                </li>

                <li class="habitat-blue darken-1"><a class="dropdown-trigger" href="#!" data-target="dropdown1"><?php echo $this->request->getSession()->read('Auth.User.username'); ?></a></li>

            </ul>
            <?php } ?>
            
    </div>
    </nav>
    
    <ul class="sidenav" id="mobile-demo">
        <li>
            <?php echo $this->Html->link('Brigadas', [
                'controller' => 'Brigadas',
                'action' => 'index',
            ]); ?>
        </li>
        <li>
            <?php echo $this->Html->link('Voluntarios', [
                'controller' => 'Voluntarios',
                'action' => 'index',
            ]); ?>
        </li>
    </ul>

</header>

<main>
    <?= $this->Flash->render() ?>
    <div class="">
        <?= $this->fetch('content') ?>
    </div>
</main>

<footer>
    <div class="container">
        <p class="white-text">Habitat for Humanity El Salvador | Privacy Policy | Feedback</p>
    </div>
</footer>

<?php use Cake\Routing\Router; ?>

<!-- https://selectize.github.io/selectize.js/ -->
<!-- http://www.naidim.org/cakephp-3-tutorial-18-autocomplete -->

    

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/country-region-dropdown-menu/1.2.1/geodatasource-cr.min.js"></script>
<?php // echo $this->Html->script('geodatasource.js'); ?>


<script>
    $('.selectize').selectize({
        maxItems: 80,
        hideSelected: false,
        placeholder: 'Name'
    });
    
    
    // $('.selectize-tag').selectize({
        // delimiter: ',',
        // persist: false,
        // create: function(input) {
            // return {
                // value: input,
                // text: input
            // }
        // }
    // });
    
    
    $('.select-vanilla').selectize({
        create: false,
        sortField: 'text'
    });
    

    $('.select-beast').selectize({
        create: true,
        sortField: 'text'
    });
    
    
    // $('.input-tags').selectize({
        // delimiter: ',',
        // persist: false,
        // create: function(input) {
            // return {
                // value: input,
                // text: input
            // }
        // }
    // });
    
</script>

<script src="https://unpkg.com/ionicons@4.4.2/dist/ionicons.js"></script>

<?= $this->fetch('bottomScript') ?>

</body>
</html>
