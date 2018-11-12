 <?php echo $this->Html->link("Retour", ['controller'=>'inscriptions','action'=>'index'],[ 'class'=>'absolute top-right']);?>
<?php echo $this->Form->create($article);?>
<div class="padding-50">

<h2>Inscriptions de clubs</h2>

<p class="center">Sélectionner votre club :
<?php echo $this->Form->input('club_id', ['label' => false, 'class'=>'associated center',  [
        'options' => $clubs]]);?></p>

<p class="center padding-1">
 <?php echo $this->Form->checkbox("new_club",['onchange'=>"newclub(this)"] ); ?>Je ne trouve pas mon club, je veux l'ajouter dans la liste.</p>
	
	<div class="newclub center display-none"><p class="center">Nom du club : </p>
<?php echo $this->Form->input("club_name", ['label'=>false]); ?>
</div>

<div class="center width-70">


<p class="center padding-1">
Responsable Club : <?php echo $this->Form->input("responsable_club", ['label'=>false,'required'=>'required']); ?>
</p>
    
<p class="center padding-1">Responsable Inscriptions (si différent) : <?php echo $this->Form->input("responsable_inscriptions", ['label'=>false]); ?></p>    
<p class="center margin-top-3 italic">Cliquer sur le "+" pour ajouter une personne</p>

    <table class="tableau-gris" style="margin-top:5px" id="addelement-table">
    <thead>  
    <tr>
    <th>Nom</th>
    <th>Prénom</th>
    <th>Sexe</th>
    <th>Grade</th>
    <th>Année de naissance</th>
    <th>Catégorie</th>
    <th>Certificat médical</th>
	<th></th>
           </tr>
        </thead>
         
        <tbody></tbody>
        <tfoot>
            <tr>
                <td colspan="7"></td>
                <td class="actions">
                    <a href="#" class="add"><?php echo $this->Html->image('plus.png',['class'=>'icon-add']);?></a>
                </td>
            </tr>
        </tfoot>
    </table>




<?php // Utilisation de x-underscore-template pour rajouter des lignes, mais m'empêche de faire des fonctions
      // de jquery globales, obligée de retomber sur des fonctions définies directement dans l'input
      
      
<script id="addelement-template" type="text/x-underscore-template">
<?php $key = isset($key) ? $key : '<%= key %>'; ?>
<tr>
    <td>
        <?php echo $this->Form->hidden("inscrits.{$key}.id") ?>
        <?php echo $this->Form->text("inscrits.{$key}.nom",['style'=>'width:80%; height:2em']); ?>
    </td>   
    <td>
     <?php echo $this->Form->input("inscrits.{$key}.prenom", ['label'=>false]); ?>
    </td>
    
    <td class="sexe-td">
       <?php echo $this->Form->select("inscrits.{$key}.sexe", 
    ['M'=>'M', 'F'=>'F'],
    ['empty' => ' ', 'class'=>'sexe','onchange'=>"categorie(this)",]); ?>
    </td>
    
    </td>
    
    
     <td class="grade">
      <?php echo $this->Form->select("inscrits.{$key}.grade", 
    [
    '-10' =>'10ème Kyu',
    '-9' =>'9ème Kyu',
    '-8' =>'8ème Kyu',
    '-7' =>'7ème Kyu',
    '-6' =>'6ème Kyu',
    '-5' =>'5ème Kyu',
    '-4' =>'4ème Kyu',
    '-3' =>'3ème Kyu',
    '-2' =>'2ème Kyu',
    '-1' =>'1er Kyu',
    '1' =>'1er Dan',
    '2' =>'2ème Dan',
    '3' =>'3ème Dan',
    '4' =>'4ème Dan',
    '5' =>'5ème Dan',
    '6' =>'6ème Dan',
    '7' =>'7ème Dan',],
    ['empty' => ' ','onchange'=>"categorie(this)",'class'=>'grade-input']); ?>
    </td>
    
    <td class="age">
     <?php
     
     echo $this->Form->input("inscrits.{$key}.age", ['class'=>'age-input', 'onchange'=>"categorie(this)",'type'=>'year','minYear' => date('Y') - 60,
    'maxYear' => date('Y') - 7,'label'=>false]); ?>
    </td>
    
    <td class="categorie">
    <span class="categorie"></span>
    <span class="surclassement-age display-none">Surclassement en Sénior ?
   <?php echo $this->Form->checkbox("inscrits.{$key}.surclassement_age"); ?>
    </span>
    
    <span class="surclassement-grade display-none">Surclassement en excellence ?
   <?php echo $this->Form->checkbox("inscrits.{$key}.surclassement_grade",['onchange'=>"surclassement(this)"]); ?>
    </span>
    
    </td>
    
       <td class="certif">
     <?php
     
     echo $this->Form->input("inscrits.{$key}.certif_medical", ['class'=>'certif-input', 'onchange'=>"certif(this)",'type'=>'year','minYear' => date('Y') - 5,
    'maxYear' => date('Y'),'label'=>false]); ?>
	<span class="certif display-none"><br />Certificat QS sur l'honneur
   <?php echo $this->Form->checkbox("inscrits.{$key}.certif_qs"); ?>
    </span>
    </td>
 
    
   
    <td class="actions">
        <a href="#" class="remove"><?php echo $this->Html->image('moins2.png',['class'=>'icon-add']);?></a>
    </td>
</tr>
</script>

</table>



 <div class="center">	
<?php echo '<p class="center">'.$this->Form->button('Envoyer', ['type' => 'submit', 'name'=>'envoyer', 'class' => 'soumettre normalButton']);?>

</div>


<?php echo $this->Form->end();?>



</div>
</div>


<p class="center padding-3"></p>

<?php 
 $this->Html->css('chosen.min', ['block' => true]); ?>




<?php $this->Html->script('chosen.jquery', ['block' => true]); ?>


<?php $this->Html->scriptStart(['block' => true]); ?>
     $(".associated").chosen({
  });

<?php $this->Html->scriptEnd(); ?>


<?php $this->Html->scriptStart(['block' => true]); ?>




function categorie(x) {
  		
   
// Pour l'age

if(x.value > 1900) {

	
 
   var sexe = $(td).prev("td").prev("td").children().val();
   var grade = $(td).prev("td").children().val();
	var td = x.parentElement.parentElement;
	
	age = x.value;
	
if(age !== '' && sexe !== '' && grade !== '') {


    if(age == 2010 || age == 2011) {

     $(td).next("td").children(".categorie").text( "Poussin" );
    
    }
    
    else if(age == 2009 || age == 2008) {
    $(td).next("td").children(".categorie").text( "Samouraï" );
    }
    
     else if(age == 2007 || age == 2006) {
    $(td).next("td").children(".categorie").text( "Benjamin" );
    }


  	else if(age == 2005 || age == 2004) {
    $(td).next("td").children(".categorie").text( "Minime" );
    }
    
    
     if(age < 2004) {
     
   
    
   
    if($(td).prev("td").prev("td").children().val() == 'M') {
     	
     	if(age == 2003 || age == 2002) 
     	{
   			 $(td).next("td").children(".categorie").text( "Cadet" );
    	}
   
   		else if(age == 2001 || age == 2000 || age == 1999) 
   		{
    
     	$(td).next("td").children(".categorie").text( "Junior" );
    	}
    
   		else if(age < '1999') {
    
    			
			if( $(td).prev("td").children().val() < '3') {
			
					
            $(td).next("td").children(".categorie").text( "Honneur" );
					
			}
	
	
			else if( $(td).prev("td").children().val() > '2') {
					
			$(td).next("td").children(".categorie").text( "Excellence" );
					
				}
			}
		}
		
	else {	
    
    if(age == 2003 || age == 2002 || age == 2001) {
    $(td).next("td").children(".categorie").text( "Espoirs" );
    }
    
    else {
    $(td).next("td").children(".categorie").text( "Femme" );		
    }
    
     
			}					
  		
  		}
  		
  		
	sexe = $(td).prev("td").prev("td").children().val();
    if(((age == '2001' || age == '2000' || age == '1999') && sexe == 'M') ||
		((age == '2001' || age == '2002' || age == '2003') && sexe == 'F')) {
    
    $(td).next("td").children(".surclassement-age").addClass('display-block');
	  $(td).next("td").children(".surclassement-age").removeClass('display-none');
	
    
    } else {
    
    $(td).next("td").children(".surclassement-age").addClass('display-none');
	  $(td).next("td").children(".surclassement-age").removeClass('display-block');
	
    
    } 
      
    
	
    
					
   sexe = $(td).prev("td").prev("td").children().val();
    grade = $(td).prev("td").children().val();
	
  
   if(sexe == 'M' && age < 2002 && (grade == 1 || grade == 2)) {
   
    $(td).next("td").children(".surclassement-grade").addClass('display-block');
	  $(td).next("td").children(".surclassement-grade").removeClass('display-none');

    } else {
    
     $(td).next("td").children(".surclassement-grade").addClass('display-none')
     $(td).next("td").children(".surclassement-grade").removeClass('display-block');
	 
    }
   
    }
     

   }

 
   // Pour les grades-----------------------------
   
   if (x.value > -10 && x.value < 10){
   var td = x.parentElement;
   grade = x.value;
  
  
  age = $(td).next("td").children().children(".age-input").val();
  sexe = $(td).prev("td").children(".sexe").val();
       		
       		
    		if(age !== '' && sexe !== '' && grade !== '') {
   	
	 if(age < '1999') {
     	if(sexe == 'M'  && grade < '3') {

		$(td).next("td").next("td").children(".categorie").text( "Honneur");

}
else if (sexe == 'M'  && grade > '2') {

	$(td).next("td").next("td").children(".categorie").text( "Excellence");

} 
	
	if(grade == 1 || grade == 2) {

	  $(td).next("td").next("td").children(".surclassement-grade").addClass('display-block');
	  $(td).next("td").next("td").children(".surclassement-grade").removeClass('display-none');

   } else {

   
     $(td).next("td").next("td").children(".surclassement-grade").addClass('display-none')
     $(td).next("td").next("td").children(".surclassement-grade").removeClass('display-block');
	 
    }
	
	

   	}
	

	 if((age == '2001' || age == '2000' || age == '1999') && sexe == 'M') {
   
   $(td).next("td").next("td").children(".surclassement-grade").addClass('display-block')
     $(td).next("td").next("td").children(".surclassement-grade").removeClass('display-none');
    
    } else {
    
    $(td).next("td").next("td").children(".surclassement-grade").addClass('display-none')
     $(td).next("td").next("td").children(".surclassement-grade").removeClass('display-block'); 
    
    } 
	
  
  }

}

// Pour le sexe ------------------------------

 if (x.value == 'F' || x.value == 'M'){

var td = x.parentElement;
sexe = x.value;

	age = $(td).next("td").next("td").children().children(".age-input").val();
   grade = $(td).next("td").children().val();
 
if(age !== '' && sexe !== '' && grade !== '') {

	if(age == '2010' || age == '2011') {

     $(td).next("td").next("td").next("td").children(".categorie").text( "Poussin" );
    
    }
    
    else if(age == '2009 '|| age == '2008') {
    $(td).next("td").next("td").next("td").children(".categorie").text( "Samouraï" );
    }
    
     else if(age == '2007' || age == '2006') {
    $(td).next("td").next("td").next("td").children(".categorie").text( "Benjamin" );
    }


  	else if(age == '2005' || age == '2004') {
    $(td).next("td").next("td").next("td").children(".categorie").text( "Minime" );
    }
    
	
	
	if(sexe == 'M') {
	
	if(age == '2003' || age == '2002') 
     	{

   			 $(td).next("td").next("td").next("td").children(".categorie").text( "Cadet" );
    	}
   
	
		else if(age == '2001' || age == '2000' || age == '1999') 
		{
 			
			$(td).next("td").next("td").next("td").children(".categorie").text( "Junior" );
		}

		else if(age < '1999') 
		{
		 
		 if(grade > 2) {
    
   			 $(td).next("td").next("td").next("td").children(".categorie").text( "Excellence" );
	
		} else if(grade < 3) {

	$(td).next("td").next("td").next("td").children(".categorie").text( "Honneur" );
	
		}
	}
}

if(age !== '' && sexe !== '' && grade !== '') {

	

if(x.value == 'F') {
	
	
	if(age == '2010' || age == '2011') {

     $(td).next("td").children(".categorie").text( "Poussin" );
    
    }
    
    else if(age == '2009 '|| age == '2008') {
    $(td).next("td").children(".categorie").text( "Samouraï" );
    }
    
     else if(age == '2007' || age == '2006') {
    $(td).next("td").children(".categorie").text( "Benjamin" );
    }


  	else if(age == '2005' || age == '2004') {
    $(td).next("td").children(".categorie").text( "Minime" );
    }
  
	else if(age == '2003' || age == '2002' || age == '2001') {
			  
			$(td).next("td").next("td").next("td").children(".categorie").text( "Espoir" );
  			
				}
  				else if(age < '2001') {
  				 $(td).next("td").next("td").next("td").children(".categorie").text( "Femme" );
  				}
					

			}
						
  			
  		}
       		
       		

   		if(sexe == 'M' && age < '2002' && (grade == '1' || grade == '2')) {
   
  
       
	  $(td).next("td").next("td").next("td").children(".surclassement-grade").addClass('display-block');
	  $(td).next("td").next("td").next("td").children(".surclassement-grade").removeClass('display-none');

   } else {


    
     $(td).next("td").next("td").next("td").children(".surclassement-grade").addClass('display-none')
     $(td).next("td").next("td").next("td").children(".surclassement-grade").removeClass('display-block');
	 
    }

	
	 if(((age == '2001' || age == '2000' || age == '1999') && sexe == 'M') ||
		((age == '2001' || age == '2002' || age == '2003') && sexe == 'F')) {
   
   $(td).next("td").next("td").next("td").children(".surclassement-age").addClass('display-block')
     $(td).next("td").next("td").next("td").children(".surclassement-age").removeClass('display-none');
	 
    
    } else {
    
    $(td).next("td").next("td").next("td").children(".surclassement-age").addClass('display-none')
     $(td).next("td").next("td").next("td").children(".surclassement-age").removeClass('display-block');
	 
    
    } 
	
	
	
  }
}

 
}




 
    function surclassement(x) {


if($(x).is(':checked')) {

if($(x).parent().prev(".surclassement-age").hasClass("display-block")) {

$(x).parent().prev(".surclassement-age").children().prop('checked', true);
 
 }    

}


}
   
   
    
    function certif(x) {
if(x.value < '2018') {


$(x).parent().next(".certif").addClass("display-block");

 }    




}

    function newclub(x) {
    

if($(x).is(':checked')) {



$(".newclub").addClass("display-block");

 }    

}



<?php $this->Html->scriptEnd(); ?>



<?php echo $this->Html->scriptStart(['block' => true]);?>
$(".soumettre").easyconfirm({locale: {
	title: 'Etes-vous sûr(e)?',
	text: "Voulez-vous envoyer vos inscriptions ?<br /><br /> Assurez vous d'avoir bien rempli toutes les colonnes avant l'envoi.",
	button: ['Annuler',' Confirmer'],
	closeText: 'fermer'
}});
<?php $this->Html->scriptEnd(); ?>

