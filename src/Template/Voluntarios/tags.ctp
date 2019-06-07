<!-- File: src/Template/Brigadas/tags.ctp -->

<h1>Tagged with <?= $this->Text->toList(h($tags), 'or') ?></h1>

<section>
<?php foreach ($brigadas as $brigada): ?>
    <brigada>
        <!-- Use the HtmlHelper to create a link -->
        <h4><?= $this->Html->link(
            $brigada->name,
            ['controller' => 'Brigadas', 'action' => 'view', $brigada->id]
        ) ?></h4>
        <span><?= h($brigada->created) ?>
    </brigada>
<?php endforeach; ?>
</section>