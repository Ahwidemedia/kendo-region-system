<div class="padding-50"></div>

<h1>Renvoyer l'email d'activation </h1>

<div class="login-panel">
<?php echo $this->Form->create();?>
<?php echo $this->Form->input('email', ['label'=>'Email']);
echo $this->Form->button('Renvoyer', ['type' => 'submit', 'class'=>'bouton-gris']);
echo $this->Form->end(); ?>
</div>