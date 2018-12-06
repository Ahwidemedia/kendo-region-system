<html>
<body>

<table width="100%" style="font-size:1.1em; background-color:#ebebeb" cellspacing="10" cellpadding="0">
<tr width="800" style="width:800px;" >
<td width="800" style="background-color:#fff; width:800px;" align="left" valign="top">

<p class="text-align:center; width:100%; margin-left:auto; margin-right:auto;">
    <?php echo $this->Html->image('logo.png', ['width'=>'345','height'=>'49','alt'=>'Inscriptions','style' => 'display:table; width:40px; height:40px; margin-left:auto; margin-right:auto;', 'fullBase' => true]); ?>
 </p>


<h1 style="text-align:center;  color:darkred; font-size:1.5em;">Vos inscriptions à la compétition 
</h1>
    <p style="text-align:center; font-weight:bold; margin-top:30px;font-size:1.2em ">Club : <?php echo $club['name']; ?></p>
    <h2 style="text-align:center; font-size:1.3em; margin-top:30px;">Inscriptions individuelles</h2>
<table style="width:80%; border-collapse: collapse; margin-left:auto; margin-right:auto">
    <tr style="background-color:#ccc">
       <th style="border: solid 1px grey; text-align:center;">N° licence</th>
                    <th style="border: solid 1px grey; text-align:center;">Nom</th>
                    <th style="border: solid 1px grey; text-align:center;">Prénom</th>
                    <th style="border: solid 1px grey; text-align:center;">Sexe</th>
                    <th style="border: solid 1px grey; text-align:center;">Grade</th>
                    <th style="border: solid 1px grey; text-align:center;">Année de naissance</th>
                    <th style="border: solid 1px grey; text-align:center;">Catégorie</th>
                    <th style="border: solid 1px grey; text-align:center;">Certificat médical</th>
                  
    </tr>
  
    <?php 
      
        foreach($recap_compete as $results){
    if($results['participation_indiv'] == 1) {
    ?>  <tr>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['numero_licence'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['nom'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['prenom'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['sexe'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['grade']['name'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['ddn'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['category']['name'];?>
               <?php 
         if($results['surclassement_age'] == 1){echo 'Surclassé en âge';}
        if($results['surclassement_grade'] == 1){echo 'Surclassé en grade';}
            ?>
        
        </td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['certificat'];?><br/>
       <?php if($results['certificat_qs'] == 1){echo 'Certificat QS';}
    ?>
        </td>
    </tr>
    <?php
} 
    
    }
    ?>
   
    </table>
    
    
        <h2 style="text-align:center; font-size:1.3em; margin-top:50px;">Inscriptions par equipe</h2>
<table style="width:80%; border-collapse: collapse; margin-left:auto; margin-right:auto">
    <tr style="background-color:#ccc">
       <th style="border: solid 1px grey; text-align:center;">N° licence</th>
                    <th style="border: solid 1px grey; text-align:center;">Nom</th>
                    <th style="border: solid 1px grey; text-align:center;">Prénom</th>
                    <th style="border: solid 1px grey; text-align:center;">Sexe</th>
                    <th style="border: solid 1px grey; text-align:center;">Grade</th>
                    <th style="border: solid 1px grey; text-align:center;">Année de naissance</th>
                    <th style="border: solid 1px grey; text-align:center;">Catégorie</th>
                    <th style="border: solid 1px grey; text-align:center;">Certificat médical</th>
                  
    </tr>
  
    <?php 
    
    $row = null;
      
        foreach($recap_compete as $results){
            
    if($results['participation_equipe'] == 1) {
        
        if($row !== $results['equipe_id']){
            
       echo '<tr><td colspan="8" style="padding:5px; font-weight:bold; border: solid 1px grey; text-align:center;">Equipe : '.$results['equipe']['name'].'</td></tr>';}
        
    ?>  
    <tr>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['numero_licence'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['nom'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['prenom'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['sexe'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['grade']['name'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['licency']['ddn'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['category']['name'];?>
        <?php 
         if($results['surclassement_age'] == 1){echo 'Surclassé en âge';}
        if($results['surclassement_grade'] == 1){echo 'Surclassé en grade';}
            ?>
          
            
        </td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $results['certificat'];?><br/>
        <?php if($results['certificat_qs'] == 1){echo 'Certificat QS';}
    ?>
        </td>
    </tr>
    
    <?php
            } 
       
    
           $row = $results['equipe_id'];
          
    }
    ?>
   
    </table>
    
   
    
         <h2 style="text-align:center; font-size:1.3em; margin-top:50px;">Inscriptions commissaires et arbitres</h2>
<table style="width:80%; border-collapse: collapse; margin-left:auto; margin-right:auto">
    <tr style="background-color:#ccc">
                <th style="border: solid 1px grey; text-align:center;">Numéro de licence</th>
                <th style="border: solid 1px grey; text-align:center;">Nom</th>
                <th style="border: solid 1px grey; text-align:center;">Prénom</th>
                <th style="border: solid 1px grey; text-align:center;">Arbitre</th>
                <th style="border: solid 1px grey; text-align:center;">Commissaire</th>
                <th style="border: solid 1px grey; text-align:center;">Samedi</th>
                <th style="border: solid 1px grey; text-align:center;">Dimanche</th>
                
            </tr>
    
    <?php
   
    foreach($recap_admin as $resultat) { 
    
    ?>
    
    

    <tr>
    <td style="border: solid 1px grey; text-align:center;"><?php echo $resultat['licency']['numero_licence'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $resultat['licency']['nom'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php echo $resultat['licency']['prenom'];?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php if($resultat['licency']['arbitre'] == 1){ echo 'Stagiaire'; } 
                                                                        elseif ($resultat['licency']['arbitre'] == 2){echo 'Diplômé Régional';}
                                                                        elseif ($resultat['licency']['arbitre'] == 3){echo 'Diplômé National';}
            
            
            ?></td>
        <td style="border: solid 1px grey; text-align:center;"><?php if($resultat['licency']['commissaire'] == 1){ echo 'Stagiaire'; } 
                                                                        elseif ($resultat['licency']['commissaire'] == 2){echo 'Diplômé Régional';}
                                                                        elseif ($resultat['licency']['commissaire'] == 3){echo 'Diplômé National';}
            ?></td>
        
        <td style="border: solid 1px grey; text-align:center;"><?php if (strpos($resultat['presence'], '1') !== false) { echo 'X'; }?></td>
         <td style="border: solid 1px grey; text-align:center;"><?php if (strpos($resultat['presence'], '2') !== false) { echo 'X'; }?></td>
    </tr>
    
    <?php } ?>
    
    </table>
    

<p style="padding:30px">&nbsp;</p>
</td>
</tr>
</table>



</body>
</html>