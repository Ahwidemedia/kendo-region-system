<?php 

$conn = $this->request->session()->read('Auth.User');

echo $this->Html->link("Retour", ['controller'=>'inscriptions','action'=>'index'],[ 'class'=>'absolute top-right']);?>


<?php echo $this->Form->create($article);?>


<div class="width-100 center">

    <h1 class="center">Inscriptions à la compétition</h1>

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




        <h2 class="center black margin-top-50-px ">
            Inscriptions individuelles
        </h2>

        <p class="center italic margin-top-3 ">Cliquer sur le "+" pour ajouter une personne</p>

        <table class="tableau-gris" style="margin-top:5px" id="addelement-table">
            <thead>
                <tr>
                    <th>N° licence</th>
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

            <tbody>
                
                <?php
                
                if(isset($articles)) {              
                foreach($articles as $articli)
            {
                
    // On sélectionne les inscriptions individuelles parmi toutes les inscriptions
                if($articli['participation_indiv'] == 1) {
                
                ?>
                <tr class="lines">
                    
                    <td>
                        
                        <?php echo $this->Form->hidden("inscription_competitions.$articli->id.licencie.id",['value'=>$articli['licency']['id']]); ?>
                        
                        <?php echo $this->Form->hidden("inscription_competitions.$articli->id.id",['value'=>$articli['id']]); ?>
                        
                <?php echo $this->Form->text("inscription_competitions.$articli->id.licencie.numero_licence",['class'=>'licence-ind','value'=>$articli['licency']['numero_licence'], 'style'=>'width:80%; height:2em']); ?>
                </td>
                <td>
                <?php echo $this->Form->text("inscription_competitions.$articli->id.licencie.nom",['class'=>'nom-ind','value'=>$articli['licency']['nom'], 'style'=>'width:80%; height:2em']); ?>
            </td> 
                <td>
                     
                     <?php echo $this->Form->text("inscription_competitions.$articli->id.licencie.prenom",['class'=>'prenom-ind','value'=>$articli['licency']['prenom'], 'style'=>'width:80%; height:2em']); ?>
                </td>
                
                 <td class="sexe-td">
       <?php echo $this->Form->select("inscription_competitions.$articli->id.licencie.sexe", 
    ['M'=>'M', 'F'=>'F'],
    ['value'=>$articli['licency']['sexe'],'empty' => ' ', 'class'=>'sexe sexe-ind','onchange'=>"categorie(this)"]); ?>
    </td>
                <td><?php echo $this->Form->input("inscription_competitions.$articli->id.licencie.grade_id", ['onchange'=>"categorie(this)",'class'=>'grade-ind grade-input','label'=>false,'value'=>$articli['licency']['grade_id'],  [
        'options' => $grades]]);?>
                    </td>
                 <td>
                     <?php
     
     echo $this->Form->input("inscription_competitions.$articli->id.licencie.ddn", ['value'=>$articli['licency']['ddn'],'class'=>'age-input ddn-ind', 'onchange'=>"categorie(this)",'type'=>'year','minYear' => date('Y') - 60,
    'maxYear' => date('Y') - 7,'label'=>false]); ?>
    </td>
               
                 <td>
                     
                     <span class="categorie"><?php echo $articli['category']['name']; ?>
                </span>
                     
                </td>
                 <td>
                  <?php
     
     echo $this->Form->input("inscription_competitions.$articli->id.certificat", ['value'=>$articli['certificat'],'class'=>'certif-input certif-ind', 'onchange'=>"certif(this)",'type'=>'year','minYear' => date('Y') - 5,
    'maxYear' => date('Y'),'label'=>false]); ?> </td>
                 <td>
                </td></tr>
              
                <?php } 
                
                }
                
                }
                ?>
                
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


        <table id="indivs">

            <?php // Utilisation de x-underscore-template pour rajouter des lignes, mais m'empêche de faire des fonctions
      // de jquery globales, obligée de retomber sur des fonctions définies directement dans l'input ?>


            <script id="addelement-template" type="text/x-underscore-template">
                <?php $key = isset($key) ? $key : '<%= key %>'; ?>
<tr class="lines">

<td> 

 <?php echo $this->Form->hidden("inscription_competitions.{$key}.id"); ?>
 
  <?php echo $this->Form->hidden("inscription_competitions.{$key}.licencie.id"); ?>
    <?php echo $this->Form->text("inscription_competitions.{$key}.licencie.numero_licence",['class'=>'licence-ind','style'=>'width:80%; height:2em']); ?>
</td>
    <td>
       
        <?php echo $this->Form->text("inscription_competitions.{$key}.licencie.nom",['class'=>'nom-ind','style'=>'width:80%; height:2em']); ?>
    </td>   
    <td>
     <?php echo $this->Form->input("inscription_competitions.{$key}.licencie.prenom", ['class'=>'prenom-ind','label'=>false]); ?>
    </td>
    
    <td class="sexe-td">
       <?php echo $this->Form->select("inscription_competitions.{$key}.licencie.sexe", 
    ['M'=>'M', 'F'=>'F'],
    ['empty' => ' ', 'class'=>'sexe sexe-ind','onchange'=>"categorie(this)"]); ?>
    </td>
    
    </td>
    
    
     <td class="grade">
       <?php echo $this->Form->input("inscription_competitions.{$key}.licencie.grade_id", ['onchange'=>"categorie(this)",'class'=>'grade-ind grade-input','label'=>false,  [
        'options' => $grades]]);?>
      
    </td>
    
    <td class="age">
     <?php
     
     echo $this->Form->input("inscription_competitions.{$key}.licencie.ddn", ['class'=>'age-input ddn-ind', 'onchange'=>"categorie(this)",'type'=>'year','minYear' => date('Y') - 60,
    'maxYear' => date('Y') - 7,'label'=>false]); ?>
    </td>
    
    <td>
    <span class="categorie"></span>
    <span class="surclassement-age display-none"><br />
   <?php echo $this->Form->checkbox("inscription_competitions.{$key}.surclassement_age", ['class'=>'surage-ind']); ?> Surclassement en Sénior ?
    </span>
    
    <span class="surclassement-grade display-none"><br />
   <?php echo $this->Form->checkbox("inscription_competitions.{$key}.surclassement_grade",['onchange'=>"surclassement(this)"]); ?> Surclassement en excellence ?
    </span>
    
    
    <span class="autorisation display-none"><br />
   <?php echo $this->Form->checkbox("inscription_competitions.{$key}.autorisation", ['class'=>'autorisation-ind']); ?> Autorisation parentale
    </span>
    
    </td>
    
       <td class="certif">
     <?php
     
     echo $this->Form->input("inscription_competitions.{$key}.certificat", ['class'=>'certif-input certif-ind', 'onchange'=>"certif(this)",'type'=>'year','minYear' => date('Y') - 5,
    'maxYear' => date('Y'),'label'=>false]); ?>
    
    
    
	<span class="certif display-none"><br />Certificat QS sur l'honneur
   <?php echo $this->Form->checkbox("inscription_competitions.{$key}.certificat_qs", ['class'=>'certif-ind']); ?>
    </span>
    </td>

 
    
   
    <td class="actions">
        <a href="#" class="remove"><?php echo $this->Html->image('moins2.png',['class'=>'icon-add']);?></a>
    </td>
</tr>
</script>

        </table>

        <?php /*----------------------- Tableau Equipes----------------------- */
        
        // Si la competition autorise les équipes
        
        if( $event['competition']['equipe'] !== 0) {
            
            // On stocke le nombre de membres autorisés par équipe
            
        $nbr_equipe = $event['competition']['equipe'];
        ?>
        <h2 class="center black margin-top-50-px ">
            Inscriptions par équipes
        </h2>

    
            
              
                <?php 
              $a = 0;
            
            $temp_array=array();
            
            // Si on a déjà des inscriptions
            
            if(isset($articles)) {   
                
                // On les prend toutes
            foreach($articles as $articli) { 
            
              // On sélectionne celles par équipe
            if($articli['participation_equipe']== 1) {
           
        
            // On ordonne dans un array pour pouvoir changer de tableau à chaque changement d'équipe
                
            $temp_array[$articli['equipe_id']][]=
                
                ['id'=>$articli['id'],
                 'licencie_id'=> $articli['licencie_id'],
                'nom_equipe'=> $articli['equipe']['name'],
                 'equipe_id'=>$articli['equipe_id'],
                 'numero_licence'=>$articli['licency']['numero_licence'],
                 'nom'=>$articli['licency']['nom'],
                 'prenom'=>$articli['licency']['prenom'],
                  'sexe'=>$articli['licency']['sexe'],
                  'ddn'=>$articli['licency']['ddn'],
                  'grade_id'=>$articli['licency']['grade_id'],
                  'certificat'=>$articli['certificat'],
                 'surclassement'=>$articli['surclassement'],
                 
                 
                ];
       
                }
            }
            
           
            
            // Pour chaque équipe
            foreach($temp_array AS $equipe_id=>$names){
                      $b=0;
              
                $a++;
               
        ?>
        
  <p class="padding-1 center">
            
            <?php echo $this->Form->checkbox("equipes.cf_equipe".$a, ['label'=>false,'id'=>'equipe'.$a,'style']); ?>Equipe <?php echo $a;?> </p>

        <div id="equipe<?php echo $a; ?>block">

            <p class="padding-1 center">Nom de l'équipe : <br />
                  
                <?php echo $this->Form->hidden("equipes.$a.equipe.id", ['value'=>$names[0]['equipe_id'],'label'=>false]); ?>
                <?php echo $this->Form->input("equipes.$a.equipe.name", ['value'=>$names[0]['nom_equipe'],'label'=>false]); ?>
            </p>

           <table class="tableau-gris margin-top-3" id="addelement-table">

                <tr>
                    <th>Numéro de licence</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th style="max-width:30px;">Sexe</th>
                    <th>Année de naissance</th>
                    <th>grade</th>
                    <th>Certificat médical</th>
                    <th>Surclassement Age</th>


                </tr>
               
             
               
              <?php  
                  // Je remplis les lignes avec les données stockées dans l'array
                
                foreach($names AS $name){ 
            
            // Je compte le nombre de lignes pour pouvoir compléter par des lignes vides
              $b++
               ?>
                <tr class="line">
                    <td>

                    
                 <?php   echo $this->Form->hidden("equipes.$a.$b.id", ['value'=>$name['id']]); ?>
                        
                        
                                 
                 <?php   echo $this->Form->hidden("equipes.$a.licencie.$b.id", ['value'=>$name['licencie_id'], 'class'=>'licencie-equipe','label'=>false]); ?>
                 <?php   echo $this->Form->input("equipes.$a.licencie.$b.numero_licence", ['value'=>$name['numero_licence'], 'class'=>'licencie-equipe','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$b.nom", ['value'=>$name['nom'],'class'=>'next-nom','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$b.prenom", ['value'=>$name['prenom'],'class'=>'next-prenom','label'=>false]); ?>
                    </td>
                    
                     <td>
                        <?php echo $this->Form->select("equipes.$a.licencie.$b.sexe", 
                        ['M'=>'M', 'F'=>'F'],
                        ['value'=>$name['sexe'],'empty' => ' ', 'class'=>'sexe next-sexe','label'=>false,'onchange'=>"categorie(this)"]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$b.ddn", ['value'=>$name['ddn'],'class'=>'age-input next-ddn', 'onchange'=>"categorie(this)",'type'=>'year','minYear' => date('Y') - 60,
                        'maxYear' => date('Y') - 7,'label'=>false]); ?>
                    </td>
                     <td class="grade">
       <?php echo $this->Form->input("equipes.$a.licencie.$b.grade_id", ['value'=>$name['grade_id'],'onchange'=>"categorie(this)",'class'=>'next-grade grade-input','label'=>false,  [
        'options' => $grades]]);?>
      
    </td>
                    <td>
                    <?php
     
     echo $this->Form->input("equipes.$a.$b.certificat", ['value'=>$name['certificat'],'class'=>' next-certif', 'onchange'=>"certif(this)",'type'=>'year','minYear' => date('Y') - 5, 'maxYear' => date('Y'),'label'=>false]); ?></td>
                    <td>
                        <?php echo $this->Form->checkbox("equipes.$a.licencie.$b.surclassement", ['value'=>$name['surclassement'],'class'=>'next-surage','label'=>false]); ?>
                    </td>

                </tr>
                
               <?php
                   
                   
                   } 
                
                
                // J'ai compté les lignes, je complètes avec des vides pour rajouter des inscros
                
                
                for($i=$b+1;$i <= $nbr_equipe; $i++) { ?>
                <tr class="line">
                    <td>
                        
                        <?php    echo $this->Form->hidden("equipes.$a.$i.id"); ?>
                        <?php     echo $this->Form->hidden("equipes.$a.licencie.$i.id"); ?>
                        <?php    echo $this->Form->input("equipes.$a.licencie.$i.numero_licence", ['class'=>'licencie-equipe','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$i.nom", ['class'=>'next-nom','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$i.prenom", ['class'=>'next-prenom','label'=>false]); ?>
                    </td>
                    
                     <td>
                        <?php echo $this->Form->select("equipes.$a.licencie.$i.sexe", 
                        ['M'=>'M', 'F'=>'F'],
                        ['empty' => ' ', 'class'=>'sexe next-sexe','label'=>false,'onchange'=>"categorie(this)"]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$i.ddn", ['class'=>'age-input next-ddn', 'onchange'=>"categorie(this)",'type'=>'year','minYear' => date('Y') - 60,
                        'maxYear' => date('Y') - 7,'label'=>false]); ?>
                    </td>
                     <td class="grade">
       <?php echo $this->Form->input("equipes.$a.licencie.$i.grade_id", ['onchange'=>"categorie(this)",'class'=>'next-grade grade-input','label'=>false,  [
        'options' => $grades]]);?>
      
    </td>
                    <td>
                   
                        
                        <?php
     
     echo $this->Form->input("equipes.$a.$i.certificat", ['class'=>' next-certif', 'onchange'=>"certif(this)",'type'=>'year','minYear' => date('Y') - 5,
    'maxYear' => date('Y'),'label'=>false]); ?>
                    <td>
                        <?php echo $this->Form->checkbox("equipes.$a.licencie.$i.surclassement", ['class'=>'next-surage','label'=>false]); ?>
                    </td>

                </tr>
<?php }
                
                
                echo '</table></div>';
                
                                                  
            }
        }
        

       
        
        
        
        // On va compléter le nombre d'équipe pour en proposer 4 en fonction des équipes déjà rentrées
        
      
        
        for($a=$a+1; $a<=4;$a++) {
            ?>
            
            
                      
  <p class="padding-1 center">
            
            <?php echo $this->Form->checkbox("equipes.cf_equipe".$a, ['label'=>false,'id'=>'equipe'.$a,'style']); ?>Equipe <?php echo $a;?> </p>

        <div id="equipe<?php echo $a; ?>block">

            <p class="padding-1 center">Nom de l'équipe : <br />
                  
                <?php echo $this->Form->hidden("equipes.$a.equipe.id", ['label'=>false]); ?>
                <?php echo $this->Form->input("equipes.$a.equipe.name", ['label'=>false]); ?>
            </p>

           <table class="tableau-gris margin-top-3" id="addelement-table">

                <tr>
                    <th>Numéro de licence</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th style="max-width:30px;">Sexe</th>
                    <th>Année de naissance</th>
                    <th>grade</th>
                    <th>Certificat médical</th>
                    <th>Surclassement Age</th>


                </tr>
               
               
            
            <?php for($i=1;$i <= $nbr_equipe; $i++) { ?>
            <tr class="line">
                    <td>
                        
                        <?php    echo $this->Form->hidden("equipes.$a.$i.id"); ?>
                        <?php     echo $this->Form->hidden("equipes.$a.licencie.$i.id"); ?>
                        <?php    echo $this->Form->input("equipes.$a.licencie.$i.numero_licence", ['class'=>'licencie-equipe','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$i.nom", ['class'=>'next-nom','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$i.prenom", ['class'=>'next-prenom','label'=>false]); ?>
                    </td>
                    
                     <td>
                        <?php echo $this->Form->select("equipes.$a.licencie.$i.sexe", 
                        ['M'=>'M', 'F'=>'F'],
                        ['empty' => ' ', 'class'=>'sexe next-sexe','label'=>false,'onchange'=>"categorie(this)"]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("equipes.$a.licencie.$i.ddn", ['class'=>'age-input next-ddn', 'onchange'=>"categorie(this)",'type'=>'year','minYear' => date('Y') - 60,
                        'maxYear' => date('Y') - 7,'label'=>false]); ?>
                    </td>
                     <td class="grade">
       <?php echo $this->Form->input("equipes.$a.licencie.$i.grade_id", ['onchange'=>"categorie(this)",'class'=>'next-grade grade-input','label'=>false,  [
        'options' => $grades]]);?>
      
    </td>
                    <td>
                   
                        
                        <?php
     
     echo $this->Form->input("equipes.$a.$i.certificat", ['class'=>' next-certif', 'onchange'=>"certif(this)",'type'=>'year','minYear' => date('Y') - 5,
    'maxYear' => date('Y'),'label'=>false]); ?>
                    <td>
                        <?php echo $this->Form->checkbox("equipes.$a.licencie.$i.surclassement", ['class'=>'next-surage','label'=>false]); ?>
                    </td>

                </tr>
               
               <?php } ?>
        
        </table></div>
            <?php
        }
       
        
         }
        
            
                ?> 
            
 
   
  
        
        


        <h2 class="center black margin-top-50-px ">
            Inscriptions arbitres et commissaires
        </h2>
        
       <a class="showSingle" data-target="Commissaires">Commissaires</a>

        
     <a class="showSingle" data-target="Arbitres">Arbitres</a>

        <?php
        
          $count1 = 1;
          $count2 = 1;                         
               
        // Si g est égal à 1, on est dans le tableau des commissaires, à 2, dans le tableau des arbitres
        
            
            for($g=1;$g <= 2; $g++) { 
        
        ?>
        
        
        <?php
                
                // On définit titre et repaire pour le targetDiv
                if($g == 1) {
            $role= "Commissaires";
            } else {
            $role= "Arbitres";
            
} ?>
        
        <div id="div<?php echo $role;?>" class="targetDiv">
        <h3><?php echo $role;?></h3>
        
        <table class="tableau-gris" style="margin-top:5px" id="addelement-table">

            <tr>
                <th>Numéro de licence</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Samedi</th>
                <th>Dimanche</th>
            </tr>
            
            
            <?php 
                                // Si on a déjà des inscriptions       
              
                         if(isset($admins)) {   
                            
                            // Pour toutes les inscriptions
                foreach($admins as $admin) {
                    
            // Si on est dans le tableau des commissaires
                    if($g == 1 && $admin['commissaire'] == 1) {
                        
            $count1++;
            
            if(strpos($admin['presence'], '1') !== false) { $checked1 = 'checked'; } else {$checked1 = ''; }
            if(strpos($admin['presence'], '2') !== false) { $checked2 = 'checked'; } else {$checked2 = ''; } 
            ?>
        
             <tr class="line">
            <td>
                        <?php echo $this->Form->hidden("administratif.$admin->id.id", ['value'=>$admin['id'],'label'=>false]); ?>

                        <?php echo $this->Form->hidden("administratif.$admin->id.$role", ['class'=>'licencie-equipe','label'=>false]); ?>

                        
                        <?php echo $this->Form->input("administratif.$admin->id.licencie.numero_licence", ['value'=>$admin['licency']['numero_licence'],'class'=>'licencie-equipe','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("administratif.$admin->id.licencie.nom", ['value'=>$admin['licency']['nom'],'class'=>'next-nom','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("administratif.$admin->id.licencie.prenom", ['value'=>$admin['licency']['prenom'],'class'=>'next-prenom','label'=>false]); ?>
                    </td>
                    
                    <td>
                    <?php echo $this->Form->checkbox("administratif.$admin->id.samedi",['checked'=>$checked1]); ?>
                </td>
                
              <td>
                    <?php echo $this->Form->checkbox("administratif.$admin->id.dimanche",['checked'=>$checked2]); ?>

                </td>
            </tr>
            
            
          <?php  } 
                   
                    // Si on est dans le tableau des arbitres
                    
                    elseif($g == 2 && $admin['arbitre'] == 1) {
                      
           $count2++;
            
            if(strpos($admin['presence'], '1') !== false) { $checked1 = 'checked'; } else {$checked1 = ''; }
            if(strpos($admin['presence'], '2') !== false) { $checked2 = 'checked'; } else {$checked2 = ''; } 
            ?>
        
             <tr class="line">
            <td>
                        <?php echo $this->Form->hidden("administratif.$admin->id.id", ['value'=>$admin['id'],'label'=>false]); ?>

                        <?php echo $this->Form->hidden("administratif.$admin->id.$role", ['class'=>'licencie-equipe','label'=>false]); ?>

                        
                        <?php echo $this->Form->input("administratif.$admin->id.licencie.numero_licence", ['value'=>$admin['licency']['numero_licence'],'class'=>'licencie-equipe','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("administratif.$admin->id.licencie.nom", ['value'=>$admin['licency']['nom'],'class'=>'next-nom','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("administratif.$admin->id.licencie.prenom", ['value'=>$admin['licency']['prenom'],'class'=>'next-prenom','label'=>false]); ?>
                    </td>
                    
                    <td>
                    <?php echo $this->Form->checkbox("administratif.$admin->id.samedi",['checked'=>$checked1]); ?>
                </td>
                
              <td>
                    <?php echo $this->Form->checkbox("administratif.$admin->id.dimanche",['checked'=>$checked2]); ?>

                </td>
            </tr>
            
            
          <?php  }
            
               
            }
            
                        }
                
                ?>
            
            
            
            
            
            
          <tr class="line">
              <?php 
                
                // On va compter le nombre de lignes remplies pour pouvoir compléter jusqu'à 10 par des lignes vides
                                       
              if($g == 1) {
              
              $e = 1;
              $f = 10 - $count1;
              
              } else {
              
              $e = 11;
              $f = 20 - $count2;
              
              } 
               for($o=$e;$o <= $f; $o++) { ?>
                   
              
              <td>
                        <?php echo $this->Form->hidden("administratif.$o.id", ['label'=>false]); ?>

                        <?php echo $this->Form->hidden("administratif.$o.$role", ['class'=>'licencie-equipe','label'=>false]); ?>

                        
                        <?php echo $this->Form->input("administratif.$o.licencie.numero_licence", ['class'=>'licencie-equipe','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("administratif.$o.licencie.nom", ['class'=>'next-nom','label'=>false]); ?>
                    </td>
                    <td>
                        <?php echo $this->Form->input("administratif.$o.licencie.prenom", ['class'=>'next-prenom','label'=>false]); ?>
                    </td>
                    
                    <td>
                    <?php echo $this->Form->checkbox("administratif.$o.samedi"); ?>
                </td>
                
              <td>
                    <?php echo $this->Form->checkbox("administratif.$o.dimanche"); ?>

                </td>
            </tr>

            <?php }
                                         
              ?>
        </table>

</div>
        
        <?php } ?>
        
       
            
        <p class="padding-3 center"></p>
        <p class="margin-top-3 center">
            Avez-vous un commentaire à ajouter à votre inscription ? <br />
            <?php echo $this->Form->input("commentaire", ['type'=>'textarea','class'=>'width-80 center','label'=>false]); ?>

        </p>
        <div class="margin-top-3 center">
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

            
            function surclassement(x) { if($(x).is(':checked')) { if($(x).parent().prev(".surclassement-age").hasClass("display-block")) { $(x).parent().prev(".surclassement-age").children().prop('checked', true); } } }
            
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
                    $('#equipe1').click(function() {
                    $("#equipe1block").toggle(this.checked);

                    });

                    $('#equipe2').click(function() {
                    $("#equipe2block").toggle(this.checked);

                    });

                    $('#equipe3').click(function() {
                    $("#equipe3block").toggle(this.checked);

                    });

                    $('#equipe4').click(function() {
                    $("#equipe4block").toggle(this.checked);

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
