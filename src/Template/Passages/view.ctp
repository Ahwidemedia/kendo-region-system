<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Passage'), ['action' => 'edit', $passage->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Passage'), ['action' => 'delete', $passage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $passage->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Passages'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Passage'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Disciplines'), ['controller' => 'Disciplines', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discipline'), ['controller' => 'Disciplines', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Evenements'), ['controller' => 'Evenements', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Evenement'), ['controller' => 'Evenements', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Inscription Passages'), ['controller' => 'InscriptionPassages', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Inscription Passage'), ['controller' => 'InscriptionPassages', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="passages view large-9 medium-8 columns content">
    <h3><?= h($passage->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($passage->name) ?></td>
        </tr>
        <tr>
            <th><?= __('Lieux') ?></th>
            <td><?= h($passage->lieux) ?></td>
        </tr>
        <tr>
            <th><?= __('Discipline') ?></th>
            <td><?= $passage->has('discipline') ? $this->Html->link($passage->discipline->name, ['controller' => 'Disciplines', 'action' => 'view', $passage->discipline->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Evenement') ?></th>
            <td><?= $passage->has('evenement') ? $this->Html->link($passage->evenement->name, ['controller' => 'Evenements', 'action' => 'view', $passage->evenement->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($passage->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Archive') ?></th>
            <td><?= $this->Number->format($passage->archive) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Passage') ?></th>
            <td><?= h($passage->date_passage) ?></td>
        </tr>
        <tr>
            <th><?= __('Date Desactivation') ?></th>
            <td><?= h($passage->date_desactivation) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($passage->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($passage->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Description') ?></h4>
        <?= $this->Text->autoParagraph(h($passage->description)); ?>
    </div>
    <div class="row">
        <h4><?= __('Document') ?></h4>
        <?= $this->Text->autoParagraph(h($passage->document)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Inscription Passages') ?></h4>
        <?php if (!empty($passage->inscription_passages)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('Commentaire') ?></th>
                <th><?= __('Accord Rgpd') ?></th>
                <th><?= __('Passage Id') ?></th>
                <th><?= __('Licencie Id') ?></th>
                <th><?= __('Grade Presente Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($passage->inscription_passages as $inscriptionPassages): ?>
            <tr>
                <td><?= h($inscriptionPassages->id) ?></td>
                <td><?= h($inscriptionPassages->commentaire) ?></td>
                <td><?= h($inscriptionPassages->accord_rgpd) ?></td>
                <td><?= h($inscriptionPassages->passage_id) ?></td>
                <td><?= h($inscriptionPassages->licencie_id) ?></td>
                <td><?= h($inscriptionPassages->grade_presente_id) ?></td>
                <td><?= h($inscriptionPassages->user_id) ?></td>
                <td><?= h($inscriptionPassages->created) ?></td>
                <td><?= h($inscriptionPassages->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'InscriptionPassages', 'action' => 'view', $inscriptionPassages->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'InscriptionPassages', 'action' => 'edit', $inscriptionPassages->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'InscriptionPassages', 'action' => 'delete', $inscriptionPassages->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscriptionPassages->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
