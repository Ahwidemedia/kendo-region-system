<h1>Les événements à venir</h1>

<?php 
$conn = $this->request->session()->read('Auth.User');

foreach ($articles as $article) { ?>
<div class="event">
    <div class="date">11/11</div>
    <div class="float-left width-70">
        <div class="img-event">

            <?php if(empty($article['image'])){$image = 'header_main.png';} else {$image = 'headers/evenements/g-'.$article['image'];}
            echo $this->html->image($image,['controller'=>'Evenements','action'=>'show',$article['id']]); ?>
        </div>
        <div class="event-presentation">
            <h2>
                <?php echo $article['name'];?>
            </h2>
            <p>Date :
                <?php echo $article['date_debut'];?> au
                <?php echo $article['date_fin'];?>
            </p>
            <p>Lieu :
                <?php echo $article['lieux'];?>
            </p>
            <p>Discipline :
                <?php echo $article['competition']['discipline_id'];?>
            </p>
        </div>
    </div>
    <div class="float-right width-30 event-menu">


        <div class="button">
            <?php echo $this->html->link('Description & règlements',['controller'=>'Evenements','action'=>'show',$article['id']]); ?>
        </div>

        <?php 
                             
                            if(!empty($article['competition'])){ ?>

        <div class="button">
            <?php echo $this->html->link('Inscriptions Shiais',['controller'=>'InscriptionCompetitions','action'=>'inscriptions',$article['competition']['id']]); ?>
            <p class="red">Vous avez actuellement 5 inscrits</p>
        </div>

        <?php 
                                                  
                                                 } 
        if(!empty($article['passage'])){ ?>

        <div class="button">
            <?php echo $this->html->link('Inscriptions passages de grades',['controller'=>'InscriptionPassages','action'=>'inscriptions',$article['passage']['id']]); ?>
            <p class="red">Vous avez actuellement 2 inscrits</p>
        </div>

        <?php } ?>

        <?php
                            
                 if($conn['id'] == $article['user_id']) { ?>
        <div class="admin-button">

            <?php echo $this->html->link('Administration',['controller'=>'Evenements','action'=>'gestion',$article['id']]); ?>
        </div>
        <?php } ?>

        <p class="red border-red font-2 width-90 center">Date de fin des inscriptions : <br />
            10/11</p>
    </div>
    <p class="clear"></p>
</div>

<?php } ?>
