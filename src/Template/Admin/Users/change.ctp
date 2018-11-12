<div class="padding-50"></div>


<h1>Editer le mot de passe de l’utilisateur </h1>

<div class="login-panel">

<?php echo $this->Form->create($user);?>

<?php echo $this->Form->input('ancienpassword', ['label'=>'Ancien mot de passe', 'type' => 'password']);?>
<?php echo $this->Form->input('password', ['label'=>'Nouveau mot de passe', 'value' => '']);?>
<?php echo $this->Form->input('passwordconfirm',['label'=>'Confirmer le nouveau mot de passe', 'type' => 'password', 'value' => '']);?>

<?php echo $this->Form->button('Envoyer', ['type' => 'submit','class'=>'bouton-gris']);?>

<?php echo $this->Form->end();?>

<?php echo $this->Html->link( 'Retour', ['action'=>'index', 'controller'=>'users']);?>



<?php echo $this->Flash->render(); ?>

</div>
