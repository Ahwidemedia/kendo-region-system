<div id="contacter" class="padding-50">
<div class=" padding-30 cinquante center blanc-soixante-dix normal-form">

<h2 class="margin-bottom-trente">Formulaire de contact</h2>

<p class="center padding-1">Pour toute question concernant la compétition, merci de vous adresser directement au
club organisateur.</p>

<p class="center padding-1">Si vous rencontrez des problèmes techniques, merci d'utiliser le formulaire suivant :  </p>

<div class="center width-50 margin-top-30-px">
<?php echo $this->Form->create($contact); ?>

<?php echo $this->Form->input('username',['label'=>"Votre nom", 'id'=>false]); ?>
<?php echo $this->Form->input('email',['label'=>"Votre e-mail"]); ?>

<?php echo $this->Form->input('sujet',['label'=>"Sujet du message"]); ?>

<?php echo $this->Form->input('message',['label'=>"Votre message", 'type'=>'textarea',
'style'=>'border:solid 1px #ccc; width:80%; font-family:ogirema; font-size:0.9em; height:150px; margin-left:auto; margin-right:auto; margin-bottom:30px;']); ?>


<div class="onnevoitpas">
<?php echo $this->Form->input('test',['label'=>"What is two plus two?", 'size'=>'4']); ?>
</div>

<?php echo $this->Form->button('Envoyer', ['type' => 'submit','class'=>'blue-button padding-trois-pourcent']);?>
</div>
<?php echo $this->Form->end(); ?>
</div>

</div>