<?php
use Cake\I18n\Time;
?>

<div class="stats-row container">
<h1>Dashboard</h1>
  <div class="row">
  
    <div class="col l4 m12">
        <div class="card">
            <div class="card-content">
            <span class="card-title">Teams in country</span>
            <?php if ($currentBrigadasCount>0){ ?>
                <table class="stats highlight">
                    <tr>
                        <th>Name</th>
                        <th>Members</th>
                        <th>Region</th>
                    </tr>
                <?php foreach ($currentBrigadas as $a):
                    echo '<tr><td><a href="brigadas/view/'. $a->id . '">' . $a->name . '</a></td><td>' . count($a->voluntarios) . '</td><td>' . $a->region . '</td></tr>';
                endforeach; ?>
                </table>
            <?php } else{ ?>
                <p>N/A</p>
            <?php } ?>    
            </div>
            <div class="card-action">
                <?= $this->Html->link('Calendar', ['controller' => 'Brigadas', 'action' => 'index'], ['class' => '']) ?>
                <?= $this->Html->link('Add a team', ['controller' => 'Brigadas', 'action' => 'add'], ['class' => '']) ?>
            </div>
        </div>

        <div class="card">
            <div class="card-content">
            <span class="card-title">Upcoming teams</span>
            <?php if ($upcomingBrigadasCount>0){ ?>
                <table class="stats highlight ">
                    <tr>
                        <th>Name</th>
                        <th class="right-align">Arriving in</th>
                    </tr>
            <?php foreach ($upcomingBrigadas as $a):
                echo '<tr><td>' . $a->name . '</td><td class="right-align">' . $a->arrival->timeAgoInWords(['format' => 'd-MMM-YYY', 'end' => '+1 month']) . '</td></tr>';
            endforeach; ?>
            </table>    
            <?php } else{ ?>
                <p>N/A</p>
            <?php } ?>
            </div>  
        </div>
        
    </div>

        
    <div class="col l4 m12">
    
        <div class="card">
            <div class="card-content">
                <span class="card-title">Teams in <?php echo date('Y') ?></span>

                <?php $months = array(
                        1   =>  'January',
                        2   =>  'February',
                        3   =>  'March',
                        4   =>  'April',
                        5   =>  'May',
                        6   =>  'June',
                        7   =>  'July',
                        8   =>  'August',
                        9   =>  'September',
                        10  =>  'October',
                        11  =>  'November',
                        12  =>  'December'
                    ) ?>
                <table class="stats ">
                    <tr>
                    <th>Month</th>
                    <th class="right-align">Total</th>
                    </tr>
                    <?php if ($graph->count() > 0){?>
                        <?php foreach ($graph as $g):?>
                            <tr>
                                <?php echo '<td>' . $months[$g->month] . ' ' . $g->year . '</td><td class="right-align">' . $g->count . '</td>'; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php }else{; ?>
                        <tr class="center-align"><td>N/A</td></tr>
                    <?php }; ?>
                </table>
                <div class="center-align">
                <?php
                    if ($graph->count() > 0){
                        $graphCount = [];
                        foreach ($graph as $g):
                            $graphCount[] = $g->count;
                        endforeach;
                        
                        $graphMod = [];
                        foreach ($graph as $g):
                            $graphMod[] = round(100*$g->count/max($graphCount));
                        endforeach;
                        
                        echo "<span class=\"text-graph black-text pulse\">{" . implode(",", $graphMod) . "}</span>";
                    }
                ?>
                </div>
            </div>
            
            <div class="card-content">
                <span class="card-title">Teams in <?php echo date('Y') -1 ?></span>

                <?php $months = array(
                        1   =>  'January',
                        2   =>  'February',
                        3   =>  'March',
                        4   =>  'April',
                        5   =>  'May',
                        6   =>  'June',
                        7   =>  'July',
                        8   =>  'August',
                        9   =>  'September',
                        10  =>  'October',
                        11  =>  'November',
                        12  =>  'December'
                    ) ?>
                <table class="stats ">
                    <tr>
                    <th>Month</th>
                    <th class="right-align">Total</th>
                    </tr>
                    <?php if ($graphLast->count() > 0){?>
                        <?php foreach ($graphLast as $g):?>
                            <tr>
                                <?php echo '<td>' . $months[$g->month] . ' ' . $g->year . '</td><td class="right-align">' . $g->count . '</td>'; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php }else{; ?>
                        <tr class="center-align"><td>N/A</td></tr>
                    <?php }; ?>
                </table>
                <div class="center-align">
                <?php
                    if ($graphLast->count() > 0){
                        $graphLastCount = [];
                        foreach ($graphLast as $g):
                            $graphLastCount[] = $g->count;
                        endforeach;
                        
                        $graphLastMod = [];
                        foreach ($graphLast as $g):
                            $graphLastMod[] = round(100*$g->count/max($graphLastCount));
                        endforeach;
                        
                        echo "<span class=\"text-graph black-text pulse\">{" . implode(",", $graphLastMod) . "}</span>";
                    }
                ?>
                </div>
            </div>
        </div>
    
        <div class="card">
            <div class="card-content">
                <span class="card-title">Total records</span>
                <table class="center-align">
                    <tr>
                        <td><ion-icon name="people" size="large"></ion-icon></td>
                        <td><?php echo $brigadasAll; ?></td>
                    </tr>
                    <tr>
                        <td><ion-icon name="person" size="large"></ion-icon></td>
                        <td><?php echo $voluntariosAll; ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-action">
                <?= $this->Html->link('Explore data', ['controller' => 'Stats', 'action' => 'search'], ['class' => '']) ?>
            </div>
        </div>                


    </div>


    <div class="col l4 m12">
        <div class="card">
            <div class="card-content">
                <span class="card-title">Manage</span>
                <ul class="collection">
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">date_range</i>
                        <?= $this->Html->link('<span class="title">Teams</span>', ['controller' => 'Brigadas', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">trending_up</i>
                        <?= $this->Html->link('<span class="title">Data</span>', ['controller' => 'Stats', 'action' => 'search'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">people</i>
                        <?= $this->Html->link('<span class="title">Volunteers</span>', ['controller' => 'Voluntarios', 'action' => 'search'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">account_circle</i>
                        <?= $this->Html->link('<span class="title">Users</span>', ['controller' => 'Users', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">location_city</i>
                        <?= $this->Html->link('<span class="title">Regions</span>', ['controller' => 'Regions', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">bubble_chart</i>
                        <?= $this->Html->link('<span class="title">Types</span>', ['controller' => 'Types', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">content_paste</i>
                        <?= $this->Html->link('<span class="title">Projects</span>', ['controller' => 'Projects', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">flag</i>
                        <?= $this->Html->link('<span class="title">Officers</span>', ['controller' => 'Officers', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">translate</i>
                        <?= $this->Html->link('<span class="title">Translators</span>', ['controller' => 'Translators', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">flight_takeoff</i>
                        <?= $this->Html->link('<span class="title">Sending Programs</span>', ['controller' => 'SendingPrograms', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>
                    <li class="collection-item avatar valign-wrapper">
                        <i class="material-icons circle black">person_pin_circle</i>
                        <?= $this->Html->link('<span class="title">Work Sites</span>', ['controller' => 'Sites', 'action' => 'index'], ['class' => 'black-text', 'escape' => false]) ?>
                    </li>

                
                </ul>
            </div>
        </div>
    </div>

        
    
    

  </div>
</div>
