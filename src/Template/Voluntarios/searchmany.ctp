<!-- File: src/Template/Voluntarios/search.ctp -->

<h1>Filter Volunteers</h1>

<form role="search">
    <div class="search-control">
        <input type="search" id="name" name="name" placeholder="First or last name">
        <select id="gender" name="gender" placeholder="Gender">
            <option value=""></option>
            <option value="F">F</option>
            <option value="M">M</option>
            <option value="Other">Other</option>
        </select>
        <input type="search" id="state" name="state" placeholder="State (abbreviated)">
        <button>Search</button>
    </div>
</form>

<table>  
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
