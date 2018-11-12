<?php $filename = "spe".DS.date("d-m-Y"). "-domaine.sql"; ?>

<div id="success" class="message success" onclick="this.classList.add('hidden-flash');"><p><?= h($message) ?></br></br><?php echo $this->Html->link("Télécharger ?", ['controller'=>'Settings','action'=>'download'],['style'=>'color:white;text-decoration: underline;']);?></p></div>
