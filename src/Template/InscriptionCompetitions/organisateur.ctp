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

	<?php if($category !== null) {
	$category_id = $category;
	if($category == 13) {$category = 'Poussins';}
	if($category == 1) {$category = 'Samourais';}
	if($category == 2) {$category = 'Benjamins';}
	if($category == 3) {$category = 'Minimes';}
	if($category == 4) {$category = 'Cadets';}
	if($category == 5) {$category = 'Juniors';}
	if($category == 6) {$category = 'Espoirs';}
	if($category == 7) {$category = 'Honneurs';}
	if($category == 8) {$category = 'Excellences';}
	if($category == 9) {$category = 'Kyusha';}
	if($category == 10) {$category = 'Femmes';}
	
	echo '<h2 class="center">Categorie '.$category.'</h2>';
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
		<?php foreach($articles as $articli){
		foreach($articli['inscrits'] as $article) {
			
			if($article['grade'] == -10) {$grade = '10ème Kyu';}
			elseif($article['grade'] == -10) {$grade = '10ème Kyu';}
			elseif($article['grade'] == -9) {$grade = '9ème Kyu';}
			elseif($article['grade'] == -8) {$grade = '8ème Kyu';}
			elseif($article['grade'] == -7) {$grade = '7ème Kyu';}
			elseif($article['grade'] == -6) {$grade = '6ème Kyu';}
			elseif($article['grade'] == -5) {$grade = '5ème Kyu';}
			elseif($article['grade'] == -4) {$grade = '4ème Kyu';}
			elseif($article['grade'] == -3) {$grade = '3ème Kyu';}
			elseif($article['grade'] == -2) {$grade = '2ème Kyu';}
			elseif($article['grade'] == -1) {$grade = '1er Kyu';}
			elseif($article['grade'] == 1) {$grade = '1er Dan';}
			elseif($article['grade'] == 2) {$grade = '2ème Dan';}
			elseif($article['grade'] == 3) {$grade = '3ème Dan';}
			elseif($article['grade'] == 4) {$grade = '4ème Dan';}
			elseif($article['grade'] == 5) {$grade = '5ème Dan';}
			elseif($article['grade'] == 6) {$grade = '6ème Dan';}
			elseif($article['grade'] == 7) {$grade = '7ème Dan';}
		?>

	<tr>
		<td></td>
		
		<td>
			<?php echo $article['nom'];  ?>
		</td>

		<td>
			<?php echo $article['prenom'];  ?>
		</td>


		<td>
			<?php echo $article['sexe'];  ?>
		</td>

		<td>
			<?php echo $grade;  ?>
		</td>

		<td>
			<?php echo $article['age'];  ?>

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
			 echo $article['certif_medical'];
			if($article['certif_qs'] == 1) {
			
			echo " / Certificat QS";
			
			}
		   ?>
		</td>

		<td>
			<?php 
			 echo $article['club']['name'];
			
		   ?>
		</td>
		
	

	</tr>

	<?php	}
		} ?>

	</tbody>
	</table>
	<p class="center padding-3">
	<?php echo $this->Html->link("Exporter la catégorie en excel", ['action'=>'export',$category_id, '_ext' => 'csv'],[ 'class'=>'center normalButton margin-3']);?>
	<?php echo $this->Html->link("Exporter la catégorie en pdf", ['action'=>'view',$category_id, '_ext' => 'pdf'],[ 'class'=>'center normalButton margin-3']);?>
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
