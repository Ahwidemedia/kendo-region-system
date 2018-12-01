

<h1>Identification</h1>


<div class="float-left width-50 center normal-form">
<h2>Connexion</h2>

<?php echo $this->Form->create($user); ?>
<p class="padding-1 center">
<?php echo $this->Form->input('username',['label'=>"Nom d'utilisateur"]); ?></p>
<p class="padding-1 center">
<?php echo $this->Form->input('password',['label'=>"Mot de passe"]); ?>
</p>
<div class="onnevoitpas">
<?php echo $this->Form->input('test',['label'=>"What is two plus two?", 'size'=>'4']); ?>
</div>
<p class="padding-1 center">
<?php echo $this->Form->button('Connexion', ['type' => 'submit', 'name'=>'Connexion', 'class'=>'normalButton']);?>
</p>
<?php echo $this->Form->end(); ?>
<p>
<p class="padding-1 center">
<?php echo $this->Html->link('Mot de passe oublié ?',  ['action' =>'forgot']); ?>
</p>

</div>

<div class="float-right width-50 center normal-form">


<h2>Pas encore de compte ?</h2>
<p class="padding-1 center">


<?php echo $this->Form->create($user);?>
<?php echo $this->Form->hidden('register');?>

<?php echo $this->Form->input('username', ['label'=>'Nom d’utilisateur *']);?>
<?php echo $this->Form->input('nom', ['label'=>'Nom']);?>
<?php echo $this->Form->input('prenom', ['label'=>'Prénom']);?>
<?php echo $this->Form->input('password', ['label'=>'Mot de passe *', 'value' => '']);?>
<?php echo $this->Form->input('passwordconfirm', ['label'=>'Confirmer le mot de passe *', 'type' => 'password', 'value' => '']);?>
<?php echo $this->Form->input('email', ['label'=>'Email *']);?>
<div class="onnevoitpas">
<?php echo $this->Form->input('test',['label'=>"What is two plus two?", 'size'=>'4']); ?>
</div>
<?php echo $this->Form->button('Envoyer', ['type' => 'submit', 'name'=>'Inscription', 'class'=>'bouton-gris']);?>

<?php echo $this->Form->end();?>

</div>
<p class="clear"></p>


