<?php 
$conn = $this->request->session()->read('Auth.User');
echo $this->Html->link("Retour", ['controller'=>'inscriptions','action'=>'index'],[ 'class'=>'absolute top-right']);
//debug($inscriptions->toArray());die;
?>

<div class="width-100 center">
	<h1 class="center">Inscriptions au passage de grade</h1>
	<?= $this->Form->create(null) ?>
    <p class="center margin-top-50-px">Sélectionner votre club :
        <?= $this->Form->input('club_id', ['label' => false, 'class'=>'associated center', 'value'=> $conn['club_id'], ['options' => $clubs, ]]) ?>
    </p>

    <p class="center padding-1">
        <?= $this->Form->checkbox("new_club",['onchange'=>"newclub(this)"] ); ?>Je ne trouve pas mon club, je veux l'ajouter dans la liste.</p>

    <div class="newclub center display-none">
        <p class="center">Nom du club : </p>
        <?= $this->Form->input("club_name", ['type'=>'text','value'=>'','label'=>false]) ?>        
        <?= $this->Form->input('region_id', ['label' => false, 'class'=>'center',  ['options' => $regions]]) ?>
    </div>

    <div class="center width-70">
        <h2 class="center black margin-top-50-px ">Inscriptions</h2>
        <p class="center italic margin-top-3 ">Cliquer sur le "+" pour ajouter une personne</p>
    	<table class="tableau-gris" style="margin-top:5px" id="tabInscription">
        	<thead>
                <tr class="tr-header">
                    <th>N° licence</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Sexe</th>
                    <th>DDN</th>
                    <th>Grade actuel</th>
                    <th>Grade présenté</th>
                    <th><a href='javascript:void(0);' style="font-size:18px;" id="addMore" title="Add More Person"><?= $this->Html->image('plus.png',['class'=>'icon-add']) ?></a></th>
                </tr>
            </thead>
            <tbody>
            <?php if(isset($inscriptions)) {              
                     foreach($inscriptions as $inscription) { ?>
              	<tr>
               		<td><?= $inscription->licency->numero_licence ?></td>
               		<td><?= $inscription->licency->nom ?></td>
               		<td><?= $inscription->licency->prenom ?></td>
               		<td><?= $inscription->licency->sexe ?></td>
               		<td><?= $inscription->licency->ddn ?></td>
               		<td><?= $inscription->licency->grade->name ?></td>
               		<td><?= $inscription->grade->name ?></td>
               		<td><?= $this->Form->postLink('Supprimer',  ['action' => 'delete', $inscription->id, $id],  [ 'class'=>'btn btn-sm btn-success', 'block' => true]) ?>
         		
               		</td>
               	</tr>   
          	<?php    }          	     
                  } ?>       
				<tr>
            		<td><?= $this->Form->text("licence",['name' => 'licence[]','label' => false, 'class'=>'nom-ind','style'=>'width:80%; height:2em']) ?></td>
                    <td><?= $this->Form->text("nom",['name' => 'nom[]','label' => false, 'class'=>'nom-ind','style'=>'width:80%; height:2em']) ?></td>
                    <td><?= $this->Form->text("prenom", ['name' => 'prenom[]','label' => false, 'class'=>'prenom-ind','style'=>'width:80%; height:2em']) ?></td>
                    <td><?= $this->Form->select("sexe", ['M'=>'M', 'F'=>'F'], ['empty' => ' ', 'name' => 'sexe[]','label' => false, 'class'=>'sexe-ind']) ?></td>
                    <td><?= $this->Form->text("ddn", ['name' => 'ddn[]','label' => false, 'class'=>'prenom-ind','style'=>'width:80%; height:2em']) ?></td>
                    <td><?= $this->Form->input("grade", ['name' => 'grade[]','label' => false, 'class'=>'grade-ind', 'style'=>'width:80%; height:2em',  ['options' => $grades]]) ?></td>                    
                    <td><?= $this->Form->input("grade", ['name' => 'grade_presente[]','label' => false, 'class'=>'grade-ind', 'style'=>'width:80%; height:2em',  ['options' => $grades]]) ?></td>
                    
                    <td><a href='javascript:void(0);' class='remove'><?= $this->Html->image('moins2.png',['class'=>'icon-add']) ?></a></td>
                </tr>
        	</tbody>
        </table>
     	
<p class="center padding-3"></p>
        <p class="margin-top-3 center">
            Avez-vous un commentaire à ajouter à votre inscription ? <br />
            <?php echo $this->Form->input("commentaire", ['type'=>'textarea','class'=>'width-80 center','label'=>false]); ?>

        </p>
        <p class="margin-top-3 center width-50"> 
                <?php echo $this->Form->checkbox("consent", ['class'=>'consent','label'=>false]); ?>
                  En soumettant ce formulaire, j'accepte que les informations saisies soient exploitées dans le cadre de l'orgaisation de la compétition.
               </p>
               
               
        <div class="margin-top-3 center ">
            <?= '<p class="center">'.$this->Form->button('Envoyer', ['disabled'=>'disabled', 'type' => 'submit', 'name'=>'envoyer', 'class' => 'soumettre normalButton']) ?>

        </div>
        
        <?= $this->Form->end() ?>
        <?= $this->fetch('postLink');?>


     
     </div>
</div>


<?php  $this->Html->scriptStart(['block' => true]); ?>
$(function(){
    $('#addMore').on('click', function() {
    	var data = $("#tabInscription tr:eq(1)").clone(true).appendTo("#tabInscription");
        data.find("input").val('');
     });
     $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
         
         if(trIndex > 0) {
             $(this).closest("tr").remove();
           } else {
             alert("Désolé, impossible de supprimer la première ligne.");
           }
      });
});      

function newclub(x) { if($(x).is(':checked')) { $(".newclub").addClass("display-block"); } } 
      
$('.consent').click(function() {
	if (this.checked) {
		$(this).parent().next().children().eq(0).children().eq(0).prop('disabled', false);   
	} else {        
       	$(this).parent().next().children().eq(0).children().eq(0).prop('disabled', true);       
    }
});

$(".soumettre").easyconfirm({locale: {
	title: 'Etes-vous sûr(e)?',
    text: "Voulez-vous envoyer vos inscriptions ?<br /><br /> Assurez vous d'avoir bien rempli toutes les colonnes avant l'envoi.",
    button: ['Annuler',' Confirmer'],
    closeText: 'fermer'
    }
});
<?php $this->Html->scriptEnd(); ?>