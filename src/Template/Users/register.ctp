<div class="padding-50"></div>



<h1>Nouvel utilisateur </h1>
<div class="login-panel">

<div class="float-left cinquante">
<?php echo $this->Html->image('site/logo.png', ['alt'=>'logo planète cuisine', 'class'=>'center dix']);?>
<h2 class="margin-bottom-trente">Rejoignez la communauté planète cuisine !</h2>
<p class="margin-dix bert">
En rejoignant Planète Cuisine, vous pourrez : 
</p>
<p class="margin-dix bert">
- Ecrire vous-même des articles et recettes,  
</p>
<p class="margin-dix bert">
- Gagner des badges pour débloquer des nouvelles fonctionnalités,
</p>
<p class="margin-dix bert">
- Améliorer les articles existants en suggérant des modifications.
</p>
<p class="margin-dix cinzel brun">C'est gratuit !</p>

</div>

<div class="float-right cinquante">

<?php echo $this->Form->create($user);?>
<?php echo $this->Form->input('username', ['label'=>'Nom d’utilisateur *']);?>
<?php echo $this->Form->input('lastname', ['label'=>'Nom']);?>
<?php echo $this->Form->input('firstname', ['label'=>'Prénom']);?>
<?php echo $this->Form->input('password', ['label'=>'Mot de passe *', 'value' => '']);?>
<?php echo $this->Form->input('passwordconfirm', ['label'=>'Confirmer le mot de passe *', 'type' => 'password', 'value' => '']);?>
<?php echo $this->Form->input('mail', ['label'=>'Email *']);?>
<p>En vous inscrivant sur Planète Cuisine, vous acceptez les <?php echo $this->Html->link('Conditions Generales d\'Utilisation',['controller'=>'Pages','action'=>'cgu']);?>.</p>
<div class="onnevoitpas">
<?php echo $this->Form->input('test',['label'=>"What is two plus two?", 'size'=>'4']); ?>
</div>
<?php echo $this->Form->button('Envoyer', ['type' => 'submit', 'class'=>'bouton-gris']);?>

<?php echo $this->Form->end();?>

</div>
<p class="clear"></p>


</div>
