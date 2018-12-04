<h1>Identification</h1>


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

        <h2>Pas encore de compte ?</h2>
        <p class="padding-1  center">

            <span class="width-90 padding-3 block center">La création de compte permet de modifier vos inscriptions jusqu'à la date limite.</span>

            <?= $this->Form->create($user)?>
            <?= $this->Form->hidden('register')?>
            <?= $this->Form->input('username', ['id'=>'username_reg','label'=>'Nom d’utilisateur *'])?>
            <?= $this->Form->input('nom', ['label'=>'Nom'])?>
            <?= $this->Form->input('prenom', ['label'=>'Prénom'])?>
            <?= $this->Form->input('password', ['id'=>'reg_password','label'=>'Mot de passe *', 'value' => ''])?>
            <?= $this->Form->input('passwordconfirm', ['id'=>'reg_password_cf','label'=>'Confirmer le mot de passe *', 'type' => 'password', 'value' => ''])?>
            <?= $this->Form->input('email', ['label'=>'Email *'])?>
            <?= $this->Form->input('club_id', ['label'=>'Club *'], ['options'=> $clubs])?>
            
             
            
            
            <div class="onnevoitpas">
                <?php echo $this->Form->input('test',['id'=>'test2','label'=>"What is two plus two?", 'size'=>'4']); ?>
            </div>
            <?php echo $this->Form->button('Envoyer', ['type' => 'submit', 'name'=>'Inscription', 'class'=>'normalButton']);?>

            <?php echo $this->Form->end();?>
            <p class="padding-3"></p>
    </div>

</div>
<p class="clear"></p>
