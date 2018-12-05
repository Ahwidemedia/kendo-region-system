<h1>Les événements à venir</h1>

<?php 
$conn = $this->request->session()->read('Auth.User');

foreach ($articles as $article) { ?>
<div class="event">
    <div class="date">
        <?php echo substr($article['date_debut'],0,-5);?>
    </div>
    <div class="float-left width-70">
        <div class="img-event">

            <?php if(empty($article['image'])){$image = 'header_main.png';} else {$image = 'headers/evenements/g-'.$article['image'];}
            echo $this->Html->image($image,['controller'=>'Evenements','action'=>'show',$article['id']]); ?>
        </div>
        <div class="event-presentation">
            <h2>
                <?php echo $article['name'];?>
            </h2>
            <p class="margin-top-3">Date :
                <?php echo $article['date_debut'];?> au
                <?php echo $article['date_fin'];?>
            </p>
            <p>Lieu :
                <?php echo $article['lieux'];?>
            </p>
            <p>Discipline :
                <?php echo $article['competition']['discipline']['name'];?>
            </p>
        </div>
    </div>
    <div class="float-right width-30 event-menu">


        <div class="button">
            <?php echo $this->Html->link('Description & règlements',['controller'=>'Evenements','action'=>'show',$article['id']]); ?>
        </div>

        <?php 
                             
                            if(!empty($article['competition'])){ ?>

        <div class="button">
            
            <?php $date = $article['date_desactivation'];
                  $date_desactivation = $date->i18nFormat('YYY-MM-dd');
                                      
                    if($date_desactivation < date('Y-m-d')){
                                
                             echo '<span class="red width-90 center border-red">Inscriptions Shiais fermées</span>';
                            
                            } else{ 
          
                                
                echo $this->Html->link('Inscriptions Shiais',['controller'=>'InscriptionCompetitions','action'=>'inscriptions',$article['competition']['id']]);
                                 }
         
            if($conn['id'] == $article['user_id']) { ?>
            <p class="red">Vous avez actuellement
                <?php echo $number_compete;?> inscrits</p>
            <?php }
            
                               
            ?>
        </div>

        <?php 
                                                  
                                                 } 
        if(!empty($article['passage'])){ ?>

        <div class="button">
            
           <?php if($date_desactivation < date('Y-m-d')){
                                
                             echo '<span class="red width-90 center border-red">Inscriptions Passages de grade fermées</span>';
                            
                            } else{ 
            
           echo $this->Html->link('Inscriptions passages de grades',['controller'=>'InscriptionPassages','action'=>'inscriptions',$article['passage']['id']]); } ?>
            
            
            <?php if($conn['id'] == $article['user_id']) { ?>
            <p class="red">Vous avez actuellement
                <?php echo $number_passage;?> inscrits</p>
            <?php } ?>
        </div>

        <?php } ?>

        <?php
                            
                 if($conn['id'] == $article['user_id']) { ?>
        <div class="admin-button">

            <?php echo $this->Html->link('Administration',['controller'=>'InscriptionCompetitions','action'=>'organisateur',$article['competition']['id']]); ?>
        </div>
        <?php } ?>

        <p class="red border-red font-2 width-90 center">Date de fin des inscriptions : <br />
            <?php echo $article['date_desactivation']; ?>
        </p>
    </div>
    <p class="clear"></p>
</div>

<?php } ?>
