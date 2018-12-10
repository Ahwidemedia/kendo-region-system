

<h1 class="padding-3 margin-3">Les fiches sont maintenant prêtes à être téléchargées</h1>

<div class="center button-blue width-25">
<?php echo $this->Form->create(null);?>
<?php echo $this->Form->submit('Télécharger', ['label' => false, 'class'=>'normalButton width-100']); ?>
</div>
<?php echo $this->Form->end();?>


<p class="font-1 center margin-3 padding-3 width-25"><?php echo $this->Html->link("Retour", ['action'=>'resume',$id],['class'=>'center margin-top-30-px']); ?></p>