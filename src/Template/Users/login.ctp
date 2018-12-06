<h1>Identification</h1>

<p class="font-1 center width-80 padding-3">Afin d'éviter les doublons , UN responsable par club doit procéder aux inscriptions pour son club. <br /><br />Vous devez pour cela vous enregistrer, vous pourrez ainsi
consulter et modifier vos inscriptions jusqu'à la date limite de réception établie par l'organisateur de la compétition.
<br /><br />Une fois cette date de passée, les inscriptions sont définitivement fermées.</p>

<div class="float-left margin-top-3 width-50 center normal-form">
    <div class="width-80 center border-grey">
        <h2>Connexion</h2>

        <?php echo $this->Form->create($user); ?>
        <p class="padding-1 center">
      
            <?php echo $this->Form->input('username',['label'=>"Nom d'utilisateur"]); ?>
        </p>
        <p class="padding-1 center">
            <?php echo $this->Form->input('password',['label'=>"Mot de passe"]); ?>
        </p>
        <div class="onnevoitpas">
            <?php echo $this->Form->input('test',['label'=>"What is two plus two?", 'size'=>'4']); ?>
        </div>
        <p class="padding-1 center">
            <?php echo $this->Form->button('Connexion', ['type' => 'submit', 'name'=>'Connexion', 'class'=>'normalButton']);?>
        </p>
        <?php echo $this->Form->end(); ?>
        <p>
            <p class="padding-1 center">
                <?php echo $this->Html->link('Mot de passe oublié ?',  ['action' =>'forgot']); ?>
            </p>
            <p class="padding-3"></p>
    </div>
</div>

<div class="float-right margin-top-3 width-50 center normal-form">

    <div class="width-80 center border-grey">

        <h2>Pas encore inscrit ?</h2>
        <p class="padding-1  center">

            <?php echo $this->Form->create($user)?>
            <?php  echo  $this->Form->hidden('register')?>
             <p class="center padding-1 black">Nom d'utilisateur *
             <span class="italic block" style="font-size:0.8em">Lettres et chiffres seulement</span></p>
            <?php  echo $this->Form->input('username', ['id'=>'username_reg','label'=>false])?>
            <?php  echo $this->Form->input('nom', ['label'=>'Nom'])?>
            <?php  echo $this->Form->input('prenom', ['label'=>'Prénom'])?>
             <p class="center padding-1 black">Mot de passe *
             <span class="italic block" style="font-size:0.8em">Minimum 8 caractères</span></p>
            <?php  echo $this->Form->input('password', ['id'=>'reg_password','label'=>false, 'value' => ''])?>
            <?php  echo $this->Form->input('passwordconfirm', ['id'=>'reg_password_cf','label'=>'Confirmer le mot de passe *', 'type' => 'password', 'value' => ''])?>
            <?php  echo $this->Form->input('email', ['label'=>'Email *'])?>
            
        
        
        <p class="center black padding-1">Sélectionner votre club :
       
                
                <?php echo $this->Form->input('club_id', ['label' => false, 'class'=>'associated center', [
        'options' => $clubs, ]]);?>
    </p>

    <p class="center padding-1">
        <?php echo $this->Form->checkbox("new_club",['onchange'=>"newclub(this)"] ); ?>Je ne trouve pas mon club, je veux l'ajouter dans la liste.</p>

    <div class="newclub center display-none">
        <p class="center padding-1">Nom du club : </p>
        <?php echo $this->Form->input("club_name", ['type'=>'text','value'=>'','label'=>false]); ?>
        
         <?php echo $this->Form->input('region_id', ['label' => false, 'class'=>'center',  [
        'options' => $regions]]);?>
    </div>

            
             
            
            
            <div class="onnevoitpas">
                <?php echo $this->Form->input('test',['id'=>'test2','label'=>"What is two plus two?", 'size'=>'4']); ?>
            </div>
            <?php echo $this->Form->button('Envoyer', ['type' => 'submit', 'name'=>'Inscription', 'class'=>'normalButton']);?>

            <?php echo $this->Form->end();?>
            <p class="padding-3"></p>
    </div>

</div>
<p class="clear"></p>

<?php 
 $this->Html->css('chosen.min', ['block' => true]); ?>




<?php $this->Html->script('chosen.jquery', ['block' => true]); ?>

<?php $this->Html->scriptStart(['block' => true]); ?>
$(".associated").chosen({
});

function newclub(x) { if($(x).is(':checked')) { $(".newclub").addClass("display-block"); } } 
           

<?php $this->Html->scriptEnd(); ?>
