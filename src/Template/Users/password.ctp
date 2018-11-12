<div class="padding-50"></div>


<h1>Modifier le mot de passe</h1>

<div class="login-panel">


<?php echo $this->Form->create('User');?>
<?php echo $this->Form->input('id', ['label'=>'id', 'type'=> 'hidden']);?>
<?php echo $this->Form->input('password', ['label'=>'Mot de passe']);?>
<?php echo $this->Form->input('passwordconfirm', ['label'=>'Confirmer le mot de passe', 'type' => 'password']);?>

<?php echo $this->Form->button('Envoyer', ['type' => 'submit', 'class'=>'bouton-gris']); ?>
<?php echo $this->Form->end();?>

</div>