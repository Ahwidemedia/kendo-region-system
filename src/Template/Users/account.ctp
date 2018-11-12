 <?php echo $this->Html->link("Retour", ['action'=>'accueil'],[ 'class'=>'retour']);?>

<div class="padding-50">
<h1>Gérer mon compte </h1>

<div class="login-panel">



<?php echo $this->Form->create($user, ['type' => 'file']);?>

<p class="cinzel">Nom d'utilisateur : </p><p class="cinzel"><span class="brun"><?php echo $user->username;?></span></p>
<?php echo $this->Form->input('lastname', ['label'=>'Nom']);?>
<?php echo $this->Form->input('firstname', ['label'=>'Prénom']);?>
<?php echo $this->Form->input('mail', ['label'=>'Email']);?>
<?php 
if(!empty($user->avatar)) {
echo '<div class="avatar centre">'.$this->Html->image($user->avatar, ['alt'=>'avatar', 'class' => 'avatar center']).'</div>';
}

	else {  echo $this->Html->image('site/no-avatar.jpg', ['alt'=>'avatar', 'class'=>'avatar']); }

 ?>
<p class="centre"><?php echo $this->Form->input('avatarf', ['label' => false, 'type' => 'file', 'style'=>'width:auto']); ?>
</p>
<p>
<?php echo $this->Form->button('Enregistrer les modifications', ['type' => 'submit', 'class'=>'bouton-gris margin-top-trente']);?>
</p>
<?php echo $this->Form->end();?>

<p>
<?php echo $this->Html->link( 'Supprimer mon compte', ['action'=>'supprimer', 'controller'=>'users']);?>
</p>

<p class="margin-top-trente">
<?php echo $this->Html->link( 'Retour', ['action'=>'accueil', 'controller'=>'users']);?>
</p>


<?php echo $this->Flash->render(); ?>
</div>
</div>