<h1 class="center">Modifier le mot de passe</h1>

<div class="width-70 center padding-3">


<?php echo $this->Form->create('User');?>
<?php echo $this->Form->input('id', ['label'=>'id', 'type'=> 'hidden']);?>
<?php echo $this->Form->input('password', ['label'=>'Nouveau mot de passe : ', 'class'=>'padding-1 margin-1']);?>
<?php echo $this->Form->input('passwordconfirm', ['label'=>'Confirmer le nouveau mot de passe : ', 'type' => 'password', 'class'=>'padding-1 margin-1']);?>

<?php echo $this->Form->button('Envoyer', ['type' => 'submit', 'class'=>'normalButton']); ?>
<?php echo $this->Form->end();?>

</div>