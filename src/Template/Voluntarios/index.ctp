<!-- File: src/Template/Voluntarios/index.ctp -->

<?php $this->assign('title', 'All Volunteers');?>

<div class="row container">
    <div class="col s12 m6">
        <h1>All volunteers</h1>
    </div>
    
    <div class="icons col s12 m6 right-align">
        <?= $this->Html->link('<i class="material-icons">add</i>', ['action' => 'add'], ['class' => 'waves-effect waves-light habitat-blue btn-floating btn-large z-depth-0 tooltipped', 
        'data-tooltip' => 'Add new', 
        'escape' => false]) ?>
        
        <a href="#" class="search-anchor waves-effect waves-light habitat-blue btn-floating btn-large tooltipped z-depth-0" 
            data-position="top" 
            data-tooltip="Filter volunteer data"
        >
            <i class="material-icons">search</i>
        </a>
        
        <?= $this->Html->link('<i class="material-icons">tune</i>', ['action' => 'search'], ['class' => 'waves-effect waves-light habitat-blue btn-floating btn-large z-depth-0 tooltipped', 
        'data-tooltip' => 'Advanced Search', 
        'escape' => false]) ?>
    </div>
</div>

<div id="search-bar" class="container">
        <form id="search" role="search" action="voluntarios/search">
        <span>
            <label>First name</label>
            <input class="white" type="search" id="firstName" name="firstName" placeholder="First name">
        </span>
            
        <span>
            <label>Last name</label>
            <input class="white" type="search" id="lastName" name="lastName" placeholder="Last name">
        </span>
        <span>
            <?php echo $this->Form->button(__('Search'), ['class' => 'btn waves-effect waves-light habitat-blue z-depth-0']); ?>
        </span>
        </form>
</div>

<table class="highlight summary container white section z-depth-1">
        <tr>
            <th class="name"><?= $this->Paginator->sort('firstName', 'Name') ?></th>
            <th>Birth Date</th>
            <th>Gender</th>
            <th>Country</th>
            <th>Action</th>
        </tr>
        <?php foreach ($voluntarios as $voluntario): ?>
        
        <tr>
            <td>
            <!-- <td class="tooltipped" data-position="left" data-tooltip="<?= $voluntario->full_name ?>"> -->
                <?= $this->Html->link($voluntario->full_name, ['action' => 'view', $voluntario->id]) ?>
            </td>
            <td><?php echo ($voluntario->birth ? $voluntario->birth : '' ) ?></td>
            <td><?= $voluntario->gender ?></td>
            <td><?= $voluntario->residenceCountry ?></td>
            <td>
                <?= $this->Html->link('Edit', ['action' => 'edit', $voluntario->id]) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

<div class="paginator container center-align">
        <ul class="pagination">
            <?php echo $this->Paginator->first('«' . __('first ')) ?>
            <?php echo $this->Paginator->prev('<' . __('prev ')) ?>
            <span class="numbers">
                <?php echo $this->Paginator->numbers() ?>
            </span>
            <?php echo $this->Paginator->next(__(' next') . '>') ?>
            <?php echo $this->Paginator->last(__(' last') . '»') ?>
        </ul>
        <p>Page <?php echo $this->Paginator->counter() ?></p>
</div>