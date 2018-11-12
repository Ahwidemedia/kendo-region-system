<div class="padding-50"></div>


<h1>Supprimer le compte</h1>
<div class="cinquante centre">
<div class="login-panel">

<p>Veuillez entrer votre mot de passe pour supprimer votre compte.</p>

<p>La suppression du compte entrainera
l'effacement de toutes vos préférences personnelles, seuls resteront vos écrits...</p>
<p>
<?php echo $this->Form->create($user);?>

<?php echo $this->Form->input('finalpassword', ['label'=>'Ancien mot de passe', 'type' => 'password']);?>
<?php echo $this->Form->input('passwordconfirme',['label'=>'Confirmer le nouveau mot de passe', 'type' => 'password', 'value' => '']);?>

<?php echo $this->Form->button('Envoyer', ['type' => 'submit', 'class'=>'bouton-gris']); ?>
<?php echo $this->Form->end();?>


</div>
</div>