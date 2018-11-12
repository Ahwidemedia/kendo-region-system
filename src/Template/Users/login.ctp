<div class="padding-50"></div>

<h1>Identification</h1>
<div class="login-panel">

<div class="center cinquante">


<?php echo $this->Form->create('User'); ?>
<p class="padding-1 center">
<?php echo $this->Form->input('username',['label'=>"Nom d'utilisateur"]); ?></p>
<p class="padding-1 center">
<?php echo $this->Form->input('password',['label'=>"Mot de passe"]); ?>
</p>
<div class="onnevoitpas">
<?php echo $this->Form->input('test',['label'=>"What is two plus two?", 'size'=>'4']); ?>
</div>
<p class="padding-1 center">
<?php echo $this->Form->button('Connexion', ['type' => 'submit','class'=>'bouton-gris']);?>
</p>
<?php echo $this->Form->end(); ?>
<p>
<p class="padding-1 center">
<?php echo $this->Html->link('Mot de passe oublié ?',  ['action' =>'forgot']); ?>
</p>
<p class="padding-1 center">
<br /><?php echo $this->Html->Link('Pas encore de compte ?',['action' => 'register']);?>
</p>
</p>
</div>
<p class="clear"></p>



</div>