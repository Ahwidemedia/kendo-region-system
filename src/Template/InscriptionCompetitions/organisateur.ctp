<?php echo $this->Html->link("Retour", ['controller'=>'Pages','action'=>'index'],[ 'class'=>'absolute top-right']);?>

<div class="width-70 center">
    <div class="onglets">
        <?php echo $this->Html->link("Tous", ['controller'=>'InscriptionCompetitions','action'=>'organisateur',$event['competition']['id']],[ 'class'=>'']);?>
<?php
    
    foreach($event['competition']['categories'] as $categories) {
   echo $this->Html->link($categories['name'], ['controller'=>'InscriptionCompetitions','action'=>'organisateur',$event['competition']['id'],$categories['id']]);
}?>
	

		<?php echo $this->Html->link("EQUIPES", ['controller'=>'inscriptions','action'=>'organisation_equipe'],[ 'class'=>'']);?>

	</div>
	<p class="padding-3">&nbsp;</p>

	<?php if($category !== null) {
	
	echo '<h2 class="center">Categorie '.$category_info['name'].'</h2>';
}
else {

$category_id = null;
}
	?>
	
	
<table class="tableau-gris" id="addelement-table">
	<thead>
		<tr><th></th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Sexe</th>
			<th>Grade</th>
			<th>Année de naissance</th>
			<?php if($category == null) { ?>
			<th>Catégorie</th>
			<?php } ?>
			<th>Surclassé</th>
		    <th>Certificat médical</th>
			<th>Club</th>
		
			</tr>
	</thead>

	<tbody>
		<?php foreach($articles as $article){
		
		?>

	<tr>
		<td></td>
		
		<td>
			<?php echo $article['licency']['nom'];  ?>
		</td>

		<td>
			<?php echo $article['licency']['prenom'];  ?>
		</td>


		<td>
			<?php echo $article['licency']['sexe'];  ?>
		</td>

		<td>
			<?php echo $article['licency']['grade']['name'];  ?>
		</td>

		<td>
			<?php echo $article['licency']['ddn'];  ?>

				<?php if($category == null) { ?>
		<td>
			<?php echo $article['category']['name'];  ?>
		</td> 
		<?php } ?>
		<td>
			<?php if($article['surclassement_age']== 1 OR $article['surclassement_grade'] == 1) {
			echo 'Oui';
			
		}  else {
			echo 'Non';
			
		} ?>
		</td>
			<td>
			<?php 
			 echo $article['certificat'];
			if($article['certificat_qs'] == 1) {
			
			echo " / Certificat QS";
			
			}
		   ?>
		</td>

		<td>
			<?php 
			 echo $article['licency']['club']['name'];
			
		   ?>
		</td>
		
	

	</tr>

	<?php	}
		 ?>

	</tbody>
	</table>
	<p class="center padding-3">
	<?php echo $this->Html->link("Exporter la catégorie en excel", ['action'=>'export',$category_info['id'], '_ext' => 'csv'],[ 'class'=>'center normalButton margin-3']);?>
	<?php echo $this->Html->link("Exporter la catégorie en pdf", ['action'=>'view',$category_info['id'], '_ext' => 'pdf'],[ 'class'=>'center normalButton margin-3']);?>
</p>
	
</div>

<?php echo $this->Html->script('datatables.min.js', ['block' => true]);
    		echo $this->Html->css('datatables.css', ['block' => true]); ?>

<?php echo $this->Html->scriptStart(['block' => true]);?>
$(document).ready( function () {
var t = $('.tableau-gris').DataTable({
"language": {
"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json",
 
},


"columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        } ],
        
    } );
 
    t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).columns(-1).order('asc').draw();
});





<?php $this->Html->scriptEnd(); ?>
