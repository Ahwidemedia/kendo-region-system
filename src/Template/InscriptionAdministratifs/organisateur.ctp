<?php echo $this->Html->link("Retour", ['controller'=>'Pages','action'=>'index'],[ 'class'=>'absolute top-right']);?>
<?php echo $this->Html->link("Modifier les données de l'évenement", ['controller'=>'Evenements','action'=>'creation',$event['id']],[ 'class'=>'float-right']);?>

<p class="clear padding-3">&nbsp;</p>
<div class="width-70 center">
    <div class="onglets">
        <?php echo $this->Html->link("Tous", ['controller'=>'InscriptionCompetitions','action'=>'organisateur',$event['competition']['id']],[ 'class'=>'']);?>
<?php
    
    foreach($event['competition']['categories'] as $categories) {
   echo $this->Html->link($categories['name'], ['controller'=>'InscriptionCompetitions','action'=>'organisateur',$event['competition']['id'],$categories['id']]);
}?>
	

		<?php echo $this->Html->link("EQUIPES", ['controller'=>'InscriptionCompetitions','action'=>'equipes',$id],[ 'class'=>'']);?>
         <?php echo $this->Html->link("ADMINISTRATIFS", ['controller'=>'InscriptionAdministratifs','action'=>'organisateur',$id],[ 'class'=>'']);?>
	</div>
	<p class="padding-3">&nbsp;</p>

	<h2>Commissaires et arbitres</h2>
	
	
<table class="tableau-gris" id="addelement-table">
	<thead>
		<tr><th></th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Niveau Arbitre</th>
            <th>Niveau Commissaire</th>
            <th>Samedi</th>
            <th>Dimanche</th>
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
			<?php if($article['licency']['arbitre'] == 1){
			 echo 'Stagiaire';
			}elseif($article['licency']['arbitre'] == 2){
            echo 'Diplômé régional';
        }
                elseif($article['licency']['arbitre'] == 3){
                    echo 'Diplômé national';
                }
		   ?>
		</td>
        <td>
        <?php if($article['licency']['commissaire'] == 1){
			 echo 'Stagiaire';
			}elseif($article['licency']['commissaire'] == 2){
            echo 'Diplômé régional';
        }
                elseif($article['licency']['commissaire'] == 3){
                    echo 'Diplômé national';
                }
		   ?>
        </td>
        <td><?php if (strpos($article['presence'], '1') !== false) {
    echo 'X';
} ?></td>
         <td><?php if (strpos($article['presence'], '2') !== false) {
    echo 'X';
} ?></td>
        
        
        <td>	<?php 
			 echo $article['licency']['club']['name'];
			
		   ?>
        
        </td>

	

	</tr>

	<?php	}
		 ?>

	</tbody>
	</table>
	<p class="center padding-3">
	<?php echo $this->Html->link("Exporter la catégorie en excel", ['action'=>'export',$id, '_ext' => 'csv'],[ 'class'=>'center normalButton margin-3']);?>
	<?php echo $this->Html->link("Exporter la catégorie en pdf", ['action'=>'view',$id, '_ext' => 'pdf'],[ 'class'=>'center normalButton margin-3']);?>
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
