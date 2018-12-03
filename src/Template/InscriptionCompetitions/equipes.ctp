   
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

	</div>
	<p class="padding-3">&nbsp;</p>
    
    <h2 style="text-align:center; font-size:1.3em; margin-top:50px;">Inscriptions par equipe</h2>
<table class="tableau-gris">
    <tr style="background-color:#ccc">
       <th >N° licence</th>
                    <th >Nom</th>
                    <th >Prénom</th>
                    <th >Sexe</th>
                    <th >Grade</th>
                    <th >Année de naissance</th>
                    <th >Surclassé</th>
                    <th >Certificat médical</th>
                    <th >Club</th>
                  
    </tr>
  
    <?php 
    
    $row = null;
      
        foreach($articles as $results){
            
    if($results['participation_equipe'] == 1) {
        
        if($row !== $results['equipe_id']){
            
       echo '<tr><td colspan="9" style="padding:5px; font-weight:bold; border: solid 1px grey; text-align:center;">Equipe : '.$results['equipe']['name'].'</td></tr>';}
        
    ?>  
    <tr>
        <td ><?php echo $results['licency']['numero_licence'];?></td>
        <td ><?php echo $results['licency']['nom'];?></td>
        <td ><?php echo $results['licency']['prenom'];?></td>
        <td ><?php echo $results['licency']['sexe'];?></td>
        <td ><?php echo $results['licency']['grade']['name'];?></td>
        <td ><?php echo $results['licency']['ddn'];?></td>
      <td>
        <?php 
         if($results['surclassement_age'] == 1){echo 'Surclassé';}
       
            ?>
          
            
        </td>
        <td ><?php echo $results['certificat'];?><br/>
        <?php if($results['certificat_qs'] == 1){echo 'Certificat QS';}
    ?>
        </td>
        <td><?php echo $results['licency']['club']['name'];?> </td>
    </tr>
    
    <?php
            } 
       
    
           $row = $results['equipe_id'];
          
    }
    ?>
   
    </table>
    
    <p class="center padding-3">
	<?php echo $this->Html->link("Exporter la catégorie en excel", ['action'=>'exportequipe',$id, '_ext' => 'csv'],[ 'class'=>'center normalButton margin-3']);?>
	<?php echo $this->Html->link("Exporter la catégorie en pdf", ['action'=>'viewequipe',$id, '_ext' => 'pdf'],[ 'class'=>'center normalButton margin-3']);?>
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

    
    