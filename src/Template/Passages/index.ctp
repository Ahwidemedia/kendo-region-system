<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Passage'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Disciplines'), ['controller' => 'Disciplines', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discipline'), ['controller' => 'Disciplines', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Evenements'), ['controller' => 'Evenements', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Evenement'), ['controller' => 'Evenements', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Inscription Passages'), ['controller' => 'InscriptionPassages', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Inscription Passage'), ['controller' => 'InscriptionPassages', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="passages index large-9 medium-8 columns content">
    <h3><?= __('Passages') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('date_passage') ?></th>
                <th><?= $this->Paginator->sort('lieux') ?></th>
                <th><?= $this->Paginator->sort('archive') ?></th>
                <th><?= $this->Paginator->sort('date_desactivation') ?></th>
                <th><?= $this->Paginator->sort('discipline_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th><?= $this->Paginator->sort('evenement_id') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($passages as $passage): ?>
            <tr>
                <td><?= $this->Number->format($passage->id) ?></td>
                <td><?= h($passage->name) ?></td>
                <td><?= h($passage->date_passage) ?></td>
                <td><?= h($passage->lieux) ?></td>
                <td><?= $this->Number->format($passage->archive) ?></td>
                <td><?= h($passage->date_desactivation) ?></td>
                <td><?= $passage->has('discipline') ? $this->Html->link($passage->discipline->name, ['controller' => 'Disciplines', 'action' => 'view', $passage->discipline->id]) : '' ?></td>
                <td><?= h($passage->created) ?></td>
                <td><?= h($passage->modified) ?></td>
                <td><?= $passage->has('evenement') ? $this->Html->link($passage->evenement->name, ['controller' => 'Evenements', 'action' => 'view', $passage->evenement->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $passage->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $passage->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $passage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $passage->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
