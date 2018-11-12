
<div class="padding-50">
<h1>Ajouter un utilisateur </h1>

<div class="login-panel">

<?php echo $this->Form->create($user);

echo $this->Form->input('username', ['label'=>'Nom d\'utilisateur *']);
echo $this->Form->input('lastname', ['label'=>'Nom']);
echo $this->Form->input('firstname', ['label'=>'Prenom']);
echo $this->Form->input('password', ['label'=>'Mot de passe *']);
echo $this->Form->input('passwordconfirm',['label'=>'Confirmer le mot de passe *', 'type' => 'password']);
echo $this->Form->input('role', ['label'=>'Role *']);
echo $this->Form->input('mail', ['label'=>'Email *']);
echo $this->Form->button('Envoyer', ['type' => 'submit', 'class'=>'bouton-gris']);

echo $this->Form->end();
echo $this->Html->link( 'Retour', ['action'=>'index', 'controller'=>'users']); ?>

<?php echo $this->Flash->render(); ?>
</div>
</div>