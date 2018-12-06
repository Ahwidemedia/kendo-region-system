<h1 class="center">Rappel du mot de passe</h1>


<div class="center width-70 font-2">
<?php echo $this->Form->create($user);?>
    <p class="center padding-1">Entrer votre email</p>
<?php echo $this->Form->input('email', ['label'=>false, 'class="width-30 center padding-1 margin-1']);
echo $this->Form->button('Renvoyer', ['type' => 'submit', 'class'=>'normalButton padding-1 margin-1']);
echo $this->Form->end(); ?>
</div>