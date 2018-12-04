<div class="width-70 center padding-3">
    <h1 class="center">
        <?php echo $article['name']; ?>
    </h1>

    <h2 class="padding-1 center">
        Date :
        <?php echo $article['date_debut'];?> au
        <?php echo $article['date_fin'];?>
    </h2>

    <h2 class="padding-1 center">Lieu :
        <?php echo $article['lieux'];?>
    </h2>

    <h2 class="padding-1 center">Discipline :
        <?php echo $article['competition']['discipline']['name'];?>
    </h2>


    <p class="padding-1">
        <?php echo $article['description'];?>
    </p>

    <p class="padding-3 clear"></p>

    <p class="float-left center  width-50">
        <?php echo $this->Html->image('pdf.jpg',['class'=>'center width-10','url'=>['/files/competitions/'.$article['document']]]); ?><br />
        Informations compétition
    </p>

    <p class="float-right center width-50">
        <?php echo $this->Html->image('pdf.jpg',['class'=>'center width-10','url'=>[$article['document']]]); ?><br />
        Informations passage de grade
    </p>

    <p class="padding-1 clear"></p>
    <p class="padding-1 margin-top-50-px red border-red font-2 width-40 center">Date de fin des inscriptions : <br />
        <?php echo $article['date_desactivation'];?>
    </p>


    <?php
    
    if (!$conn = $this->request->session()->read('Auth.User')){ ?>
   
        <div class="button">
            <?php echo $this->Html->link('Inscriptions Shiais',['controller'=>'InscriptionCompetitions','action'=>'inscriptions',$article['competition']['id']]); ?>
          <?php if($conn['id'] == $article['user_id']) { ?>  <p class="red">Vous avez actuellement <?php echo $number_compete;?> inscrits</p> <?php } ?>
        </div>

        <?php 
                                                  
                                                  
        if(!empty($article['passage'])){ ?>

        <div class="button">
            <?php echo $this->Html->link('Inscriptions passages de grades',['controller'=>'InscriptionPassages','action'=>'inscriptions',$article['passage']['id']]); ?>
           <?php if($conn['id'] == $article['user_id']) { ?>  <p class="red">Vous avez actuellement <?php echo $number_passage;?> inscrits</p> <?php } ?>
        </div>

        <?php } ?>
    
    <?php } else { ?>
    <div class="button">
        <p class="padding-3 float-left center">
            <?php 
        $date = $article['date_desactivation'];
                  $date_desactivation = $date->i18nFormat('YYY-MM-dd');
        
  if($date_desactivation < date('Y-m-d')){
                                
                             echo '<span class=" red width-90 center">Inscriptions Shiais fermées</span>';
                            
                            } else{ 
        
        echo $this->Html->link('Modifier les inscriptions Shiais',['controller'=>'InscriptionCompetitions', 'action'=>'inscriptions',$article['competition']['id']]); } ?>
        </p>
    </div>
    <div class="button">
        <p class="padding-3 float-right center">
            <?php 
          if($date_desactivation < date('Y-m-d')){
                                
                             echo '<span class=" red width-90 center">Inscriptions Passages de grade fermées</span>';
                            
                            } else{ 
        echo $this->Html->link('Modifier les inscriptions Passages de grade',['controller'=>'InscriptionPassages', 'action'=>'inscriptions',$article['passage']['id']]); } ?>
        </p>
    </div>

    <p class="clear padding-3">&nbsp;</p>

    <?php 
                 
} ?>
</div>
