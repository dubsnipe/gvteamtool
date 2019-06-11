<!-- File: src/Template/Brigadas/view.ctp -->
<?php $this->assign('title', $brigada->name);?>

<?php if ($brigada->photo){ ?>



    <div class="team-photo parallax-container container-2 z-depth-1">
            
            <?php echo $this->Html->image('../webroot/files/Brigadas/photo' . $brigada->photo_dir . '/' . $brigada->photo, ['class' => 'responsive-img materialboxed', ]); ?>
    </div>
    
    
    <?php 
    echo $cell = $this->cell('DeletePhoto', [$brigada->id]); ?>
    
<?php }; ?>
                

<div class="container-2 white section z-depth-1">
    
    <h1>Team Profile<br><span class="subtitle"><?= h($brigada->name) ?></span></h1>

    <div class="section">            
        
        <h2 class="form-title">Team Information</h2>
        <table class="highlight">

        <tbody>
            <tr>
                <td>Name</td>
                <td>
                    <?php echo ($brigada->name ? $brigada->name : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <?php if ($brigada->status == 1){ ?>
                        <span class="green-text">Approved</span>
                            <?php } else{ ?>
                        <span class="red-text">Cancelled</span>
                    <?php };?>
                </td>
            </tr>
            <tr>
                <td>GV Code</td>
                <td>
                    <?php echo ($brigada->gvCode ? $brigada->gvCode : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Team Type</td>
                <td>
                    <?php echo ($brigada->team_type ? $brigada->team_type : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Arrival</td>
                <td>
                    <?php echo ($brigada->arrival ? $brigada->arrival->nice() : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Departure</td>
                <td>
                    <?php echo ($brigada->departure ? $brigada->departure->nice() : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Region</td>
                <td>
                    <?php echo ($brigada->regio ? $brigada->region : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Project</td>
                <td>
                    <?php echo ($brigada->project ? $brigada->project : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>GV Officer</td>
                <td>
                    <?php echo ($brigada->officer ? $brigada->officer : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Translator</td>
                <td>
                    <?php echo ($brigada->translator ? $brigada->translator : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Sending Program</td>
                <td>
                    <?php echo ($brigada->sending_program ? $brigada->sending_program : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Funds budgeted</td>
                <td>
                    <?php echo ($brigada->funds_budgeted ? $this->Number->currency($brigada->funds_budgeted, 'USD') : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Funds received</td>
                <td>
                    <?php echo ($brigada->funds_received ? $this->Number->currency($brigada->received, 'USD') : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Tags</td>
                <td>
                    <?php foreach ($brigada->tags as $tag): ?>
                      <div class="chip">
                        <?= h($tag->title); ?>
                      </div>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td>Notes</td>
                <td>
                    <?php echo ($brigada->comments ? $brigada->comments : 'N/A'); ?>
                </td>
            </tr>
        </tbody>
        </table>
    </div>

</div>
<div class="container-2">
    <h2>Participants (<?php echo sizeof($brigada->voluntarios); ?>)</h2>
    <?php if (sizeof($brigada->voluntarios) > 0): ?>
    
    <div class="voluntario-wrapper">
        <?php foreach ($brigada->voluntarios as $key=>$voluntario): ?>  
          <div class="card">
            <div class="card-content">
              <span class="card-title voluntario">
                <?php echo $this->Html->link(
                    $voluntario->full_name,
                    ['controller' => 'Voluntarios', 'action' => 'view', $voluntario->id],
                    ['class' => 'black-text']
                    ); 
                ?>
              </span>
              
              <span class="star"><?php if ($voluntario->_joinData->lider){echo ('<i class="material-icons yellow-text" size="large">star</i>');};?></span>
            </div>
          </div>
          <?php endforeach; ?>
        
    </div>
    
    <?php endif; ?>


    <div class="row padded-top">
        <div class="col">
            <?= $this->Html->link('<i class="material-icons">edit</i>', ['action' => 'edit', $brigada->id], ['class' => 'waves-effect waves-light habitat-blue btn-floating btn-large', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="material-icons">accessibility</i>', ['action' => 'add_leaders', $brigada->id], ['class' => 'waves-effect waves-light habitat-blue btn-floating btn-large', 'escape' => false]) ?>
        </div>
    </div>
</div>

