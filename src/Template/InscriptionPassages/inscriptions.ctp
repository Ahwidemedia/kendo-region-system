<?php 
$conn = $this->request->session()->read('Auth.User');
echo $this->Html->link("Retour", ['controller'=>'inscriptions','action'=>'index'],[ 'class'=>'absolute top-right']);
?>

<?= $this->Form->create($passage) ?>

<div class="width-100 center">
	<h1 class="center">Inscriptions au passage de grade</h1>

    <p class="center margin-top-50-px">Sélectionner votre club :
        <?php echo $this->Form->input('club_id', ['label' => false, 'class'=>'associated center', 'value'=> $conn['club_id'], [
        'options' => $clubs, ]]);?>
    </p>

    <p class="center padding-1">
        <?php echo $this->Form->checkbox("new_club",['onchange'=>"newclub(this)"] ); ?>Je ne trouve pas mon club, je veux l'ajouter dans la liste.</p>

    <div class="newclub center display-none">
        <p class="center">Nom du club : </p>
        <?php echo $this->Form->input("club_name", ['type'=>'text','value'=>'','label'=>false]); ?>
        
         <?php echo $this->Form->input('region_id', ['label' => false, 'class'=>'center',  [
        'options' => $regions]]);?>
    </div>

    <div class="center width-70">
        <h2 class="center black margin-top-50-px ">Inscriptions</h2>
        <p class="center italic margin-top-3 ">Cliquer sur le "+" pour ajouter une personne</p>
        <table class="tableau-gris" style="margin-top:5px" id="addelement-table">
            <thead>
                <tr>
                    <th width="20%">N° licence</th>
                    <th width="25%">Nom</th>
                    <th width="20%">Prénom</th>
                    <th width="10%">Sexe</th>
                    <th width="10%">Grade</th>
                    <th width="10%">Grade présenté</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
            <?php
            if(isset($inscriptions)) {              
                foreach($inscriptions as $inscription) { ?>
               		<tr class="lines">
                    	<td>                        
                            <?= $this->Form->hidden("inscription_passages.$inscription->id.licencie.id",['value' => $inscription['licency']['id']]) ?>                        
                            <?= $this->Form->hidden("inscription_passages.$inscription->id.id",['value' => $inscription['id']]); ?>
                            <?= $this->Form->text("inscription_passages.$inscription->id.licencie.numero_licence",['class'=>'licence-ind','value'=>$inscription['licency']['numero_licence'], 'style'=>'width:80%; height:2em']) ?>
                		</td>
                		<td>
                            <?= $this->Form->text("inscription_competitions.$inscription->id.licencie.nom",['class'=>'nom-ind','value'=>$inscription['licency']['nom'], 'style'=>'width:80%; height:2em']) ?>
                        </td> 
                        <td>                             
                            <?= $this->Form->text("inscription_competitions.$inscription->id.licencie.prenom",['class'=>'prenom-ind','value'=>$inscription['licency']['prenom'], 'style'=>'width:80%; height:2em']) ?>
                        </td>
                		<td class="sexe-td">
       						<?= $this->Form->select("inscription_competitions.$inscription->id.licencie.sexe", 
                                                    ['M'=>'M', 'F'=>'F'],
                                                    ['value'=>$inscription['licency']['sexe'],'empty' => ' ', 'class'=>'sexe sexe-ind','onchange'=>"categorie(this)"]) ?>
    					</td>
                		
						<td></td>
						<td></td>
                
                 		<td>
                 			<?= $this->Form->postLink(  '-',  ['action' => 'deleteInsctiption', $inscription->id,$id],  [ 'class'=>'font-2', 'block' => true])  ?>
                		</td>
                	</tr>              
                <?php     
                }
            } ?>                
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8"></td>
                    <td class="actions">
                        <a href="#" class="add">
                            <?php echo $this->Html->image('plus.png',['class'=>'icon-add']);?></a>
                    </td>
                </tr>
            </tfoot>
        </table>


        <?= $this->Form->end() ?>
        <?= $this->fetch('postLink');?>

<p class="center padding-3"></p>

<?php 
 $this->Html->css('chosen.min', ['block' => true]); ?>




<?php $this->Html->script('chosen.jquery', ['block' => true]); ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(".associated").chosen({
});

<?php $this->Html->scriptEnd(); ?>


<?php $this->Html->scriptStart(['block' => true]); ?>

<?php // Il n'est pas possible d'appeler de manière générale la fonction à cause de la table, on appelle donc avec un onchange sur l'input,
// en récupérant la valeur x ?>
function categorie(x) {

<?php // On remonte pour trouver la ligne sur laquelle on est en train de travailler ?>

var row = $(x).closest('tr');

<?php // On définit les variables pour trouver la catégorie ?>


var age = $(row).find('.age-input').val();
var grade = $(row).find('.grade-input').val();
var sexe = $(row).find('.sexe').val();

<?php // On va comparer avec chaque catégorie de la base ?>


<?php foreach($categories as $category) { ?>
    
    <?php // Si la catégorie est mixte ou le grade est , on ne met rien dans les conditions est egal à 0 

    
    if($category['sexe'] == 'X') {
        
        $sexe = '';
    } else {
        
        $sexe = '&& (sexe == "'.$category['sexe'].'")';
    }
    
    if($category['grade_debut'] == '0') {
        
        $grade = '';
        
    } else {
        
        $grade = "&& (grade >= ".$category['grade_debut']." && grade <= ".$category['grade_fin'].")";
    }


// On compare ensuite les années dans tous les cas
?>

if((age >= <?php echo $category['annee_debut']; ?> && age <= <?php echo $category['annee_fin']; ?>)
                                                            
           <?php echo $sexe; ?>
           <?php echo $grade; ?>){
                                                             
        <?php // On remplie le span categorie avec la catégorie trouvée ?>
 
    $(row).find('.categorie').text("<?php echo $category['name'] ;?> ");
                                         
<?php // On affiche ou pas les possibilités de surclassement, autorisations parentales selon les categories ?>
                                                             
 <?php  
        if($category['mineur'] == 1) {  ?>
        
        $(row).find(".autorisation").addClass('display-block');
        $(row).find(".autorisation").removeClass('display-none');
    
                                                             
      <?php  
    }    else { ?>
        $(row).find(".autorisation").removeClass('display-block');
        $(row).find(".autorisation").addClass('display-none');
        
 <?php   }                                                   
                                         
                                         
                                         
        if($category['name'] == "JUNIORS") {  ?>
        
        $(row).find(".surclassement-age").addClass('display-block');
        $(row).find(".surclassement-age").removeClass('display-none');
    
                                                             
      <?php  
    }    else { ?>
        $(row).find(".surclassement-age").removeClass('display-block');
        $(row).find(".surclassement-age").addClass('display-none');
        
 <?php   }   ?>                            
                 
   <?php   if($category['name'] == "JUNIORS" OR $category['name'] == "HONNEURS") {  ?>                                                           
                                                             
        $(row).find(".surclassement-grade").addClass('display-block');
        $(row).find(".surclassement-grade").removeClass('display-none');
    
                                                             
      <?php  
    }    else { ?>
        $(row).find(".surclassement-grade").removeClass('display-block');
        $(row).find(".surclassement-grade").addClass('display-none');
        
 <?php   }   ?>   
    }
<?php } ?>



}


<?php $this->Html->scriptEnd(); ?>


<?php  $this->Html->scriptStart(['block' => true]); ?>

            
            function surclassement(x) { 
                
    
        if($(x).is(':checked')) { 
        if($(x).parent().prev(".surclassement-age").hasClass("display-block")) {
            $(x).parent().prev(".surclassement-age").children().prop('checked', true); 
                                                             }
                                                         } 
                                                    }
            
            function certif(x) { if(x.value < '2018' ) { $(x).parent().next(".certif").addClass("display-block"); } }
            
            function newclub(x) { if($(x).is(':checked')) { $(".newclub").addClass("display-block"); } } 
           
            <?php $this->Html->scriptEnd();  ?>


 <?php echo $this->Html->scriptStart(['block' => true]);?>

$(".licencie-equipe").blur(function(){

var licence = $( this ).val();
var currentrow = $(this).closest('tr');
var nextnom = $(currentrow).find('.next-nom');
var nextprenom = $(currentrow).find('.next-prenom');
var nextsexe = $(currentrow).find('.next-sexe');
var nextddn = $(currentrow).find('.next-ddn');
var nextgrade = $(currentrow).find('.next-grade');
var nextcertif = $(currentrow).find('.next-certif');
var nextsurage = $(currentrow).find('.next-surage');


$(function() {
  var data = $(".lines :input").serializeArray(); 
 
                                                                    
                       
  data.forEach(function(e) {
  if (licence == e.value)
    {       

   var rowe = $('input[name="'+e.name+'"]').closest('tr');

var rowenom = $(rowe).find('.nom-ind').val(); 
var roweprenom = $(rowe).find('.prenom-ind').val(); 
var rowesexe = $(rowe).find('.sexe-ind').val(); 
var roweddn = $(rowe).find('.ddn-ind').val(); 
var rowegrade = $(rowe).find('.grade-ind').val(); 
var rowecertif = $(rowe).find('.certif-ind').val(); 
var rowesurage = $(rowe).find('.surage-ind'); 


nextnom.val(rowenom);
nextprenom.val(roweprenom);
nextsexe.val(rowesexe);
nextddn.val(roweddn);
nextgrade.val(rowegrade);
nextcertif.val(rowecertif);

if(rowesurage.is(':checked')) {
nextsurage.prop('checked', true);
} 
 
                                         
                                         }
});                                     
                                         


 
});                                        
                                         

});
<?php $this->Html->scriptEnd();  ?>


                    <?php echo $this->Html->scriptStart(['block' => true]);?>
                    $(".soumettre").easyconfirm({locale: {
                    title: 'Etes-vous sûr(e)?',
                    text: "Voulez-vous envoyer vos inscriptions ?<br /><br /> Assurez vous d'avoir bien rempli toutes les colonnes avant l'envoi.",
                    button: ['Annuler',' Confirmer'],
                    closeText: 'fermer'
                    }});
                    <?php $this->Html->scriptEnd(); ?>

           <?php echo $this->Html->scriptStart(['block' => true]);?>
        $(document).ready(function() {
        
        $('input[type="checkbox"][checked="checked"]').parent().next().show();
        } );
        
        
          $('.checkequipe').click(function() {
         $(this).parent().next().toggle(this.checked);
         if (this.checked) {
        $(this).parent().next().children().eq(1).children().eq(0).prop('required',true);
        } else {
         $(this).parent().next().children().eq(1).children().eq(0).prop('required',false);
        
        }
        });
        
        
    
        
        
       <?php $this->Html->scriptEnd(); ?>
        
      

 <?php echo $this->Html->scriptStart(['block' => true]);?>
$(document).ready(function() {
$('.showSingle').on('click', function () {
    $(this).addClass('selected').siblings().removeClass('selected');
    $('.targetDiv').hide();
    $('#div' + $(this).data('target')).show(300);
});
$('.showSingle').first().click();
});

 <?php $this->Html->scriptEnd(); ?>
