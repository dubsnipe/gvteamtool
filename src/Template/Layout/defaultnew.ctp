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
    <title>Calendario :: HPHES</title>
    
    <!-- Desactivo carpetas estáticas
    <?= $this->Html->meta('icon') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?> 
    -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    
    <script
      src="https://code.jquery.com/jquery-2.2.4.min.js"
      integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
      crossorigin="anonymous"></script>
    <script
      src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
      integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
      crossorigin="anonymous"></script>
      
    <script src="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"></script>
    
</head>
<body>
    <header>
        <nav class="z-depth-0">
            <div class="nav-wrapper black">
                <div class="container">
                    <a href=""><?php echo $this->Html->getCrumbList(); ?></a>
                    <ul class="right">
                        <li><a target="_blank" href="voluntarios/">Voluntarios</a></li>
                        <li><a target="_blank" href="brigadas/">Brigadas</a></li>
                        <li><a target="_blank" href="tags/">Tags</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <?= $this->Flash->render() ?>
        <div class="container clearfix">
            <?= $this->fetch('content') ?>
        </div>
    <main>
    
    <footer>
        <div class="container">HPHES.</div>
    </footer>

<?php use Cake\Routing\Router; ?>
<script>
jQuery('#brigadas-ids').autocomplete({
    source:'<?php echo Router::url(array('controller' => 'Brigadas', 'action' => 'getAll')); ?>',
    minLength: 3
});
</script>
    
</body>
</html>
