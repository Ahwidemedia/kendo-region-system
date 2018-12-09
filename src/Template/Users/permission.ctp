<div class="message failure" onclick="this.classList.add('hidden-flash');">
	<p>Vous ne disposer pas des droits pour atteindre cette page</p>
	<p class="center padding-3"><?php echo $this->Html->link("Retour",['controller'=>'Pages', 'action'=>'index'],['class'=>'font-2 center border-red padding-1 margin-3']);?> </p>
</div>
