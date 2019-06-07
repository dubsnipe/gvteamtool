<!-- File: src/Template/Voluntarios/search.ctp -->

<?php $this->assign('title', 'Volunteers Search');?>
<?php use Cake\Routing\Router; ?>

<div class="container">
    <h1>Filter Volunteers</h1>
</div>

<div id="search-advanced" class="search-control row white section container-2 z-depth-1">
    <form role="search">
            
            <!--<div class="col s6">
                <label for="firstName">First Name</label>
                <input class="validate" type="search" id="firstName" name="firstName" value="<?php echo(isset($_GET['firstName']) ? $_GET['firstName'] : ""); ?>" placeholder="First name">
            </div>
            
            
            <div class="col s6">
                <label for="lastName">Last Name</label>
                <input class="validate" type="search" id="lastName" name="lastName" placeholder="Last name" value="<?php echo(isset($_GET['lastName']) ? $_GET['lastName'] : ""); ?>">
            </div> -->
           
            <div class="col s12">
                <label for="full_name">Name</label>
                <input id="full_name" name="full_name" type="text" placeholder="First or last name" oninput="check(this.value)">
            </div>
            
            <div class="col s6">
                <label for="gender">Gender</label>
                <select class="browser-default" id="gender" name="gender" placeholder="Gender">
                    <option value=""></option>
                    <option 
                        <?php echo(isset($_GET['gender']) && $_GET['gender'] == 'F' ? 'selected = "selected"' : ""); ?>
                        value="F">F</option>
                    <option 
                        <?php echo(isset($_GET['gender']) && $_GET['gender'] == 'M' ? 'selected = "selected"' : ""); ?>
                        value="M">M</option>
                    <option 
                        <?php echo(isset($_GET['gender']) && $_GET['gender'] == 'Other' ? 'selected = "selected"' : ""); ?>
                        value="Other">Other</option>
                </select>
            </div>
            
            <div class="col s6">
                <label for="country">Email address</label>
                <input class="validate" type="email" id="email" name="email" placeholder="myemailaddress@aol.com" value="<?php echo(isset($_GET['email']) ? $_GET['email'] : ""); ?>">
            </div>
            
            <div class="col s6">
                <label for="residence">City, State (abbreviated), or ZIP Code</label>
                <input class="validate" type="search" id="residence" name="residence" placeholder="NY" value="<?php echo(isset($_GET['residence']) ? $_GET['residence'] : ""); ?>">
            </div>
            
            <div class="col s6">
                <label for="country">Country</label>
                <input class="validate" type="search" id="country" name="country" placeholder="Country" value="<?php echo(isset($_GET['country']) ? $_GET['country'] : ""); ?>">
            </div>
            
            <div class="col">
                <?php echo $this->Form->button(__('Filter'), ['class' => 'btn waves-effect waves-light habitat-blue z-depth-0']); ?>
            </div>
    </form>
</div>

<div class="container">
    <?php echo $this->Html->link('Download results', [
                                'controller' => 'Stats', 
                                'action' => 'exportVoluntarios', 
                                '_full' => true, 
                                '?' => $queryParams
                                ], 
                                ['class' => 
                                    'waves-effect waves-light btn habitat-blue z-depth-0'
                                ]);?>
</div>

<table class="highlight responsive-table summary container white section z-depth-1">
    <tr>
        <th><?= $this->Paginator->sort('firstName', 'Name') ?></th>
        <th>Birth Date</th>
        <th>Gender</th>
        <th>Country</th>
        <th>Action</th>
    </tr>
    <?php foreach ($voluntarios as $voluntario): ?>
    
    <tr>
        <td><?= $this->Html->link($voluntario->firstName . ' ' . $voluntario->lastName, ['action' => 'view', $voluntario->id]) ?></td>
        <td><?= $voluntario->birth ?></td>
        <td><?= $voluntario->gender ?></td>
        <td><?= $voluntario->residenceCountry ?></td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $voluntario->id]) ?> 
                |
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $voluntario->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="paginator center-align">
    <ul class="pagination">
        <?php echo $this->Paginator->first('« ' . __('first')) ?>
        <?php echo $this->Paginator->prev('< ' . __('previous')) ?>
        <?php echo $this->Paginator->numbers() ?>
        <?php echo $this->Paginator->next(__('next') . ' >') ?>
        <?php echo $this->Paginator->last(__('last') . ' »') ?>
    </ul>
    <p>page <?php echo $this->Paginator->counter() ?></p>
</div>



<?php $this->Html->scriptStart(['block' => 'bottomScript']); ?>

function check() {
    var term = $('#full_name').serialize();
    console.log(term);
    $('#full_name').autocomplete({
        source: function( request, response ) {
            $.ajax({
                url: "<?php echo Router::url(['controller' => 'Voluntarios', 'action' => 'voluntariosAjax']); ?>",
                type: "POST",
                beforeSend: function(xhr){
                    xhr.setRequestHeader("X-CSRF-Token", $('[name="_csrfToken"]').val());
                },
                dataType: 'json',
                data: term,
                success: function(data) {
                    obj = [];
                    for(var i in data){
                        obj.push(data[0].full_name);
                        response(obj);
                    }
                },
            });
        },
        delay: 100,
        minLength: 3,
        close: function() {},
        focus: function(event,ui) {},
        select: function(event, ui) {}
    });
};

<?php $this->Html->scriptEnd(); ?>