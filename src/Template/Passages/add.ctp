<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Passages'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Disciplines'), ['controller' => 'Disciplines', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discipline'), ['controller' => 'Disciplines', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Evenements'), ['controller' => 'Evenements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Evenement'), ['controller' => 'Evenements', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Inscription Passages'), ['controller' => 'InscriptionPassages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Inscription Passage'), ['controller' => 'InscriptionPassages', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="passages form large-9 medium-8 columns content">
    <?= $this->Form->create($passage) ?>
    <fieldset>
        <legend><?= __('Add Passage') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('date_passage');
            echo $this->Form->input('lieux');
            echo $this->Form->input('description');
            echo $this->Form->input('archive');
            echo $this->Form->input('date_desactivation', ['empty' => true]);
            echo $this->Form->input('document');
            echo $this->Form->input('discipline_id', ['options' => $disciplines]);
            echo $this->Form->input('evenement_id', ['options' => $evenements]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
