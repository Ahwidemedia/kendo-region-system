<?php echo $this->Html->link("Retour", ['controller'=>'inscriptions','action'=>'index'],[ 'class'=>'absolute top-right']);?>

<div class="width-70 center">

	<div class="onglets">
		<?php echo $this->Html->link("Tous", ['controller'=>'inscriptions','action'=>'organisateur'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Poussins", ['controller'=>'inscriptions','action'=>'organisateur','13'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Samourais", ['controller'=>'inscriptions','action'=>'organisateur','1'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Benjamins", ['controller'=>'inscriptions','action'=>'organisateur','2'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Minimes", ['controller'=>'inscriptions','action'=>'organisateur','3'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Cadets", ['controller'=>'inscriptions','action'=>'organisateur','4'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Juniors", ['controller'=>'inscriptions','action'=>'organisateur','6'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Espoirs", ['controller'=>'inscriptions','action'=>'organisateur','5'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Honneurs", ['controller'=>'inscriptions','action'=>'organisateur','7'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Excellence", ['controller'=>'inscriptions','action'=>'organisateur','8'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Kyusha", ['controller'=>'inscriptions','action'=>'organisateur','9'],[ 'class'=>'']);?>

		<?php echo $this->Html->link("Femmes", ['controller'=>'inscriptions','action'=>'organisateur','10'],[ 'class'=>'']);?>
	
		<?php echo $this->Html->link("Les inscriptions", ['controller'=>'inscriptions','action'=>'gestion'],[ 'class'=>'']);?>

	</div>
	<p class="padding-3">&nbsp;</p>

	
	
	
<table class="tableau-gris">
	<thead>
		<tr>
			<th>Club</th>
			<th>Responsable club</th>
			<th>Responsable inscriptions</th>
			<th>Nombre d'inscrits</th>
			<th>Date</th>
		
			
			</tr>
	</thead>

	<tbody>
		<?php foreach($articles as $article){ ?>
		
		<td>
			<?php 
			 echo $article['club']['name'];	
		   ?>
		</td>
		<td>
			<?php 
			 echo $article['responsable_club'];
		   ?>
		</td>
		
		<td>
			<?php 
			 echo $article['responsable_inscriptions'];
		   ?>
		</td>
		<td>
			<?php 
			 echo $article['inscrits'][0]['count'];
		   ?>
		</td>
		<td>
			<?php 
			 echo $article['created'];
		   ?>
		</td>

	


	</tr>

	<?php	}
		 ?>

	</tbody>
	</table>
	
</div>

<?php echo $this->Html->script('datatables.min.js', ['block' => true]);
    		echo $this->Html->css('datatables.css', ['block' => true]); ?>

<?php echo $this->Html->scriptStart(['block' => true]);?>
$(document).ready( function () {
$('.tableau-gris').DataTable({
"language": {
"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
 
},
});

} );

<?php $this->Html->scriptEnd(); ?>
