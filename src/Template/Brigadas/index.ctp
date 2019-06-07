<!-- File: src/Template/Brigadas/index.ctp -->
<?php $this->assign('title', 'All Teams');?>

<?php use Cake\Routing\Router; ?>
        
<div class="row container">
    <div class="col s12 m6">
        <h1>All teams</h1>
    </div>
    <div class="icons col s12 m6 right-align">
        
        <a href="javascript:;" class="approved-anchor waves-effect waves-light habitat-green btn-floating btn-large tooltipped z-depth-0" 
            data-position="top" 
            data-tooltip="Hide/view cancelled teams"
        >
            <i class="material-icons">check</i>
        </a>
        
        <?= $this->Html->link('<i class="material-icons">add</i>', ['action' => 'add'], ['class' => 'waves-effect waves-light habitat-blue btn-floating btn-large z-depth-0 tooltipped', 
        'data-position' => 'top',
        'data-tooltip' => 'Add new', 
        'escape' => false]) ?>
        
        <a href="#" class="search-anchor waves-effect waves-light habitat-blue btn-floating btn-large tooltipped z-depth-0" 
            data-position="top" 
            data-tooltip="Filter team data"
        >
            <i class="material-icons">search</i>
        </a>
        
        <?= $this->Html->link('<i class="material-icons">tune</i>', ['action' => 'search'], ['class' => 'waves-effect waves-light habitat-blue btn-floating btn-large z-depth-0 tooltipped', 
        'data-position' => 'top',
        'data-tooltip' => 'Advanced Search', 
        'escape' => false]) ?>
    </div>
</div>

<div id="search-bar" class="container">
    <div class="right">
        <form id="search" role="search" action="brigadas/search" class="row">
            <label>Search by team name</label>
            <input class="white" type="search" id="name" name="name" placeholder="e.g. HFH Des Moines">
        </form>
    </div>
</div>

<table class="highlight summary container white section z-depth-1">
    <tr>
        <th class="name"><?= $this->Paginator->sort('name', 'Name') ?></th>
        <th class="status"><i class="material-icons">event_available</i></th>
        <th class="gvcode hide-on-med-and-down">GV Code</th>
        <th class="type hide-on-med-and-down">Type</th>
        <th class="leaders hide-on-med-and-down">TL</th>
        <th class="number">#</th>
        <th>Region</th>
        <th class="hide-on-large-only">
            <?php 
            $type = $this->Paginator->sortDir() === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down';
            $icon = "<i class='material-icons'>" . $type . "</i> Period";
            echo $this->Paginator->sort('arrival', $icon, array('escape' => false)); ?>
        </th>
        <th class="hide-on-med-and-down">
            <?php 
            // https://stackoverflow.com/questions/18287628/cakephp-table-sorting-with-bootstrap-icons
            $type = $this->Paginator->sortDir() === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down';
            $icon = "<i class='material-icons'>" . $type . "</i> Arrival";
            echo $this->Paginator->sort('arrival', $icon, array('escape' => false)); ?>
        </th>
        <th class="hide-on-med-and-down">
        <?php 
            $type = $this->Paginator->sortDir() === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down';
            $icon = "<i class='material-icons'>" . $type . "</i> Departure";
            echo $this->Paginator->sort('departure', $icon, array('escape' => false)); ?>
        </th>
        <th class="hide-on-med-and-down">Action</th>
    </tr>
    
    <?php foreach ($brigadas as $brigada): ?>
        <?php if ($brigada->status == 1){ ?>
            <tr>
                <?php } else{ ?>
            <tr class="cancelled-team">
        <?php };?>
        <td class="tooltipped" data-position="left" data-tooltip="<?= $brigada->name ?>">
            <?= $this->Html->link($brigada->name, ['action' => 'view', $brigada->id]) ?>
        </td>
        
        <?php if ($brigada->status == 1){ ?>
            <td class="habitat-green"></td>
                <?php } else{ ?>
            <td class="habitat-brick"></td>
        <?php };?>

        
        <td class="hide-on-med-and-down"><?= $brigada->gvCode ?></td>
        <td class="type hide-on-med-and-down"><?= $brigada->team_type ?></td>
        
        <?php 
            $teamLeaders = [];
            foreach($brigada->voluntarios as $b){
              if($b->_joinData->lider){
                  $teamLeaders[] = $b->firstName . ' ' . $b->lastName;
              }
            };
            $teamLeadersAll = implode(', ', $teamLeaders);
        ?>
        <td class="leaders hide-on-med-and-down <?= $teamLeadersAll ? "tooltipped" : "" ; ?>" data-position="left" data-tooltip="<?= $teamLeadersAll ?>" >
            <?= $teamLeadersAll ? $teamLeadersAll : "" ; ?>
        </td>
        <td><?= count($brigada->voluntarios) ?></td>
        <td><?= $brigada->region ?></td>
        <td class="hide-on-large-only"><?php echo ($brigada->arrival ? $brigada->arrival->format('M-d') : '') . ($brigada->departure ? ' / '.$brigada->departure->format('M-d') : '' ); ?></td>
        
        <td class="hide-on-med-and-down"><?php echo ($brigada->arrival ? $brigada->arrival->nice() : '' ); ?></td>
        <td class="hide-on-med-and-down"><?php if ($brigada->departure){
            echo $brigada->departure->nice();
                } else{ 
            echo '';
        };?></td>
        
        <td class="hide-on-med-and-down"><?= $this->Html->link('Edit', ['action' => 'edit', $brigada->id]) ?> </td>
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
