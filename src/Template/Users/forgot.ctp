<div class="padding-50"></div>

<h1>Rappel du mot de passe</h1>


<div class="login-panel">
<?php echo $this->Form->create($user);?>
<?php echo $this->Form->input('email', ['label'=>'Email']);
echo $this->Form->button('Renvoyer', ['type' => 'submit', 'class'=>'bouton-gris']);
echo $this->Form->end(); ?>
</div>