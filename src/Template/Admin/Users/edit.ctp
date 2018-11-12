 <?php echo $this->Html->link("Retour", ['action'=>'index'],[ 'class'=>'retour']);?>

<div class="padding-50">
<h1>Editer un utilisateur </h1>

<div class="login-panel">



<?php echo $this->Form->create($user, ['type' => 'file']);?>

<?php echo $this->Form->input('username', ['label'=>'Nom d\'utilisateur *']);?>
<?php echo $this->Form->input('lastname', ['label'=>'Nom']);?>
<?php echo $this->Form->input('firstname', ['label'=>'Prénom']);?>
<?php echo $this->Form->input('mail', ['label'=>'Email *']);?>
<?php echo $this->Form->input('role', ['label'=>'Role *']);?>
<?php 
if(!empty($user->avatar)) {
echo '<div class="avatar centre">'.$this->Html->image($user->avatar, ['alt'=>'avatar', 'class' => 'avatar center']).'</div>';
}

	else {  echo $this->Html->image('site/no-avatar.jpg', ['alt'=>'avatar', 'class'=>'avatar']); }

 ?>
<?php echo $this->Form->input('avatarf', ['label' => false, 'type' => 'file']); ?>

<?php echo $this->Form->button('Envoyer', ['type' => 'submit', 'class'=>'bouton-gris']);?>

<?php echo $this->Form->end();?>

<?php echo $this->Html->link( 'Changer le mot de passe', ['action'=>'change',$user->id]);?>

<?php echo $this->Html->link( 'Retour', ['action'=>'index', 'controller'=>'users']);?>



<?php echo $this->Flash->render(); ?>
</div>
</div>