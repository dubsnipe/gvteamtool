<!-- File: src/Template/Voluntarios/view.ctp -->
<?php $this->assign('title', $voluntario->full_name);?>

<div class="container-2 white section z-depth-1">

    <h1>Volunteer Profile<br><span class="subtitle"><?= h($voluntario->full_name) ?></span></h1>
    
    <div class="section">
        <h2 class="form-title">Personal Information</h2>
        <?php
            if ($voluntario->birth){
                // https://stackoverflow.com/questions/3776682/php-calculate-age
                // Resté 2000 de la respuesta porque no me funcionaba.
                //date in mm/dd/yyyy format; or it can be in other formats as well
                $birthDate = h($voluntario->birth);
                //explode the date to get month, day and year
                $birthDate = explode("-", $birthDate);
                //get age from date or birthdate
                $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[2], $birthDate[1], $birthDate[0]))) > date("md")
                ? ((date("Y") - $birthDate[0]) - 1)
                : (date("Y") - $birthDate[0]));
            } ?>
        
        <table class="highlight">
        <tbody>
            <tr>
                <td>Name</td>
                <td><?= h($voluntario->full_name) ?></td>
            </tr>
            <tr>
                <td>Birth</td>
                <td>
                    <?php if ($voluntario->birth): ?>
                        Date of birth: <?= h($voluntario->birth->nice()) ?> (<?= $age ?> years old)
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>
                    <?= h($voluntario->gender) ?>
                </td>
            </tr>
            <tr>
                <td>Address</td>
                <?php 
                    $fullAddress = [];
                    if($voluntario->address): array_push($fullAddress, $voluntario->address); endif;
                    if($voluntario->city): array_push($fullAddress, $voluntario->city); endif;
                    if($voluntario->state): array_push($fullAddress, $voluntario->state); endif;
                    if($voluntario->residenceCountry): array_push($fullAddress, $voluntario->residenceCountry); endif;
                    if($voluntario->postalCode): array_push($fullAddress, $voluntario->postalCode); endif;            
                ?>
                <td>
                    <?php echo(implode(', ', $fullAddress)); ?>
                </td>
            </tr>
            <tr>
                <td>Telephone</td>
                <td><?= h($voluntario->phone) ?></td>
            </tr>
        </tbody>
        </table>

        <h2 class="form-title">Trip Logistics</h2>
        <table class="hightlight">
        <tbody>
            <tr>
                <td>Diet</td>
                <td>
                    <?php echo ($voluntario->dietaryRestrictions ? $voluntario->dietaryRestrictions : 'None reported'); ?>
                </td>
            </tr>
            <tr>
                <td>Allergies</td>
                <td>
                    <?php echo ($voluntario->allergies ? $voluntario->allergies : 'None reported'); ?>
                </td>
            </tr>
        </tbody>
        </table>

        <h2 class="form-title">Emergency Information</h2>
        <table class="hightlight">
            <tbody>
            <tr>
                <td>Passport Country</td>
                <td>
                    <?php echo ($voluntario->passportCountry ? $voluntario->passportCountry : 'N/A'); ?>
                </td>
            </tr>
            <tr>
                <td>Health Considerations</td>
                <td>
                    <?php echo ($voluntario->healthConsiderations ? $voluntario->healthConsiderations : 'None reported'); ?>
                </td>
            </tr>
            <tr>
                <td>Emergency Contact</td>
                <td>
                    <?php echo ($voluntario->emergencyContact ? $voluntario->emergencyContact : 'None reported'); ?>
                </td>
            </tr>
            <tr>
                <td>Emergency Phone Number</td>
                <td>
                    <?php echo ($voluntario->emergencyNumber ? $voluntario->emergencyNumber : 'None reported'); ?>
                </td>
            </tr>
            </tbody>
        </table>
        
    </div>
</div>
    
<div class="container-2">    
    <h2 class="form-title">Teams (<?php echo sizeof($voluntario->brigadas); ?>)</h2>
    <?php if ($voluntario->brigadas): ?>
    <table class="highlight white section z-depth-1">
        <tbody>
            <tr>
                <th>#</th>
                <th>Team</th>
                <th>Year</th>
                <th>As Team Leader</th>
            </tr>
            <?php
                for ($i = 0; $i < count($voluntario->brigadas); ++$i): 
                $brigada = $voluntario->brigadas[$i];
            ?>    
            <tr>
                <td>
                <?php echo $i+1; ?>
                </td>
                <td>
                <?php echo $this->Html->link(
                            $brigada->name, [
                            'controller' => 'Brigadas', 
                            'action' => 'view', 
                            $brigada->id,
                        ], ['class' => '',]
                        ); ?>
                </td>
                <td>
                <?php echo date_format($brigada->arrival, "Y"); ?>
                </td>
                <td>
                    <?php if ($voluntario->brigadas[$i]->_joinData->lider){echo ('<i class="material-icons habitat-blue-text" size="large">star</i>');};?>
                </td>            
            </tr>
            <?php endfor; ?>
        <tbody>
    </table>
    <?php endif; ?>

    <div class="row padded-top">
        <div class="col">
            <?= $this->Html->link('<i class="material-icons">edit</i>', 
            ['action' => 'edit', $voluntario->id], 
            [
                'class' => 'waves-effect waves-light habitat-blue btn-floating btn-large', 
                'escape' => false
            ]) ?>
            
            <?= $this->Form->postLink('<i class="material-icons">delete</i>', 
            ['action' => 'delete', $voluntario->id], [
                'class' => 'waves-effect waves-light habitat-brick btn-floating btn-large', 
                'escape' => false
            ], ['confirm' => 'Are You Sure?','class' => 'button']) ?>
        </div>
    </div>
</div>
