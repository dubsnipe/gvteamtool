<!-- File: src/Template/Brigadas/search.ctp -->

<div class="container">
    <h1>
        Filter teams
        <br><span class="subtitle"><?php echo $this->Paginator->params()['count'] ?> items found</span>
    </h1>
</div>


<div id="search-advanced" class="search-control container-2 row white section z-depth-1">
    <form role="search">
            <div class="col l6 m12 ">
                <label for="firstName">Team Name</label>
                <input class="validate" type="text" id="name" name="name" value="<?php echo(isset($_GET['name']) ? $_GET['name'] : ""); ?>" placeholder="HFH Charlotte">
            </div>
            
            <div class="col l6 m12 ">
                <label for="gvCode">GV Code</label>
                <input class="validate" type="text" id="gvCode" name="gvCode" placeholder="GV15123" value="<?php echo(isset($_GET['gvCode']) ? $_GET['gvCode'] : ""); ?>">
            </div>
            
            <div class="col l6 m12 ">
                <label for="country">Region</label>
                <input class="validate" type="text" id="region" name="region" placeholder="Santa Ana" value="<?php echo(isset($_GET['region']) ? $_GET['region'] : ""); ?>">
            </div>

            
            <div class="col l6 m12 ">
                <label for="lastName">Earliest date of arrival</label>
                <input class="validate" type="date" id="arrivalAfter" name="arrivalAfter" placeholder="" value="<?php echo(isset($_GET['arrivalAfter']) ? $_GET['arrivalAfter'] : ""); ?>">
            </div>
     
            <div class="col l6 m12 ">
                <label for="lastName">Latest date of arrival</label>
                <input class="validate" type="date" id="arrivalBefore" name="arrivalBefore" placeholder="" value="<?php echo(isset($_GET['arrivalBefore']) ? $_GET['arrivalBefore'] : ""); ?>">
            </div>            

            <div class="col s12 section switch center-align">
                <label>
                    All teams
                    <?php if (isset($_GET['status']) and $_GET['status'] == 'on'){?>
                        <input checked type="checkbox" id="status" name="status">
                    <?php }else{ ?> 
                        <input type="checkbox" id="status" name="status">
                    <?php }; ?>
                    <span class="lever"></span>
                    Active only
                </label>
            </div>
    
            <div class="col s12 center-align">
                <?php echo $this->Form->button(__('Filter'), ['class' => 'btn waves-effect waves-light habitat-blue z-depth-0']); ?>
            </div>
            
    </form>
    </div>
</div>

<div class="container">
    <?php echo $this->Html->link('Download results', [
                                'controller' => 'Stats', 
                                'action' => 'export', 
                                '_full' => true, 
                                '?' => $queryParams
                                ], 
                                ['class' => 
                                    'waves-effect waves-light btn habitat-blue z-depth-0'
                                ]);?>
</div>


<table class="highlight responsive-table summary container white section z-depth-1">

    <tr>
        <th width="90">#</th>
        <th class="status"><i class="material-icons">event_available</i></th>
        <th width="240"><?= $this->Paginator->sort('name', 'Name') ?></th>
        <th width="35"></th>
        <th>GV Code</th>
        <th>Type</th>
        <th>Region</th>
        <th>
            <?php 
            $type = $this->Paginator->sortDir() === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down';
            $icon = "<i class='material-icons'>" . $type . "</i> Arrival";
            echo $this->Paginator->sort('arrival', $icon, array('escape' => false)); ?>
        </th>
        <th>
        <?php 
            $type = $this->Paginator->sortDir() === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down';
            $icon = "<i class='material-icons'>" . $type . "</i> Departure";
            echo $this->Paginator->sort('departure', $icon, array('escape' => false)); ?>
        </th>
        <th>Action</th>
    </tr>
    <?php $i = 0; ?>
    <?php foreach ($brigadas as $brigada): ?>
    <?php $i++; ?>
    <?php $multiplier = ($this->Paginator->params()['page'] -1) * $this->Paginator->params()['perPage']; ?>
    
    <?php if ($brigada->status == 1){ ?>
            <tr>
                <?php } else{ ?>
            <tr class="cancelled-team">
    <?php };?>
    
        <td><?php  echo $multiplier + $i; ?></td>
        <?php if ($brigada->status == 1){ ?>
            <td class="habitat-green"></td>
                <?php } else{ ?>
            <td class="habitat-brick"></td>
        <?php };?>
        <td>
            <?= $this->Html->link($brigada->name, ['action' => 'view', $brigada->id]) ?>
        </td>
        
        <?php if ($brigada->status == 1){ ?>
            <td bg color="#00e64d"></td>
                <?php } else{ ?>
            <td bg color="#ff3333"></td>
        <?php };?>
        
        <td><?= $brigada->gvCode ?></td>
        <td><?= $brigada->team_type ?></td>
        <td><?= $brigada->region ?></td>
        <td><?php if ($brigada->arrival){
            echo $brigada->arrival->nice();
                } else{ 
            echo '';
        };?></td>
        <td><?php if ($brigada->departure){
            echo $brigada->departure->nice();
                } else{ 
            echo '';
        };?></td>
        
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $brigada->id]) ?> 
                |
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $brigada->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
    
<div class="paginator container center-align">
    <ul class="pagination">
        <?php echo $this->Paginator->first('« ' . __('first')) ?>
        <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
        <?php echo $this->Paginator->numbers() ?>
        <?php echo $this->Paginator->next(__('next') . ' >') ?>
        <?php echo $this->Paginator->last(__('last') . ' »') ?>
    </ul>
    <p>page <?php echo $this->Paginator->counter() ?></p>
</div>