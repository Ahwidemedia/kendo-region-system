<?php echo $this->Html->link("Retour", ['controller'=>'Pages','action'=>'index'],[ 'class'=>'absolute top-right']);?>
<?php echo $this->Form->create($article, ['type' => 'file']);?>
<div class="padding-50 width-40 center normal-form">

    <h2>Création d'un événement</h2>



    <p class="center padding-3">
        Nom de la compétition :
        <?php echo $this->Form->input("name", ['label'=>false,'required'=>'required']); ?>
    </p>

    <p class="center padding-3">Date début :

        <?php echo $this->Form->input('date_debut', ['type'=>'text', 'id'=>'datepicker', 'label'=>false]); ?>

        <?php echo $this->Html->scriptStart(['block' => true]);?>

        $('#datepicker').datepicker({ dateFormat: 'dd/mm/yy',
        minDate: 0,
        onSelect: function (date) {
        var date2 = $('#datepicker').datepicker('getDate');
        date2.setDate(date2.getDate() + 1);
        $('#datepicker2').datepicker('setDate', date2);
        //sets minDate to dt1 date + 1
        $('#datepicker2').datepicker('option', 'minDate', date2);}
        });
        <?php $this->Html->scriptEnd(); ?>


    </p>



    <p class="center padding-3">Date fin :

        <?php echo $this->Form->input('date_fin', ['type'=>'text', 'id'=>'datepicker2', 'label'=>false]); ?>
    </p>

    <?php echo $this->Html->scriptStart(['block' => true]);?>
    $('#datepicker2').datepicker({ dateFormat: 'dd/mm/yy',onClose: function () {
    var dt1 = $('#datepicker').datepicker('getDate');
    console.log(dt1);
    var dt2 = $('#datepicker2').datepicker('getDate');
    if (dt1 >= dt2) { var minDate=$('#datepicker2').datepicker('option', 'minDate' ); $('#datepicker2').datepicker('setDate', minDate); } } });
    <?php $this->Html->scriptEnd(); ?>




    <p class="center padding-3">Lieu :
        <?php echo $this->Form->input("lieux", ['label'=>false]); ?>
    </p>

    <p class="center padding-3">Image :
        <?php echo $this->Form->input('imagef', ['label' => false, 'class'=>'center','type' => 'file']); ?>
    </p>

    <p class="center padding-3">Description :
        <?php echo $this->Form->input("description", ['type'=>'textarea','class'=>'width-100','label'=>false]); ?>
    </p>

    <div class="padding-3">
        <?php if($article['competition'] !== null) { $checked_compete = 'checked';} else {$checked_compete = '';}
        
        echo $this->Form->checkbox("cfcompetitions",["checked"=>$checked_compete,'id'=>'cfcompetition']); ?>Compétition
        
        <?php if($article['passage'] !== null) { $checked_passage = 'checked';} else {$checked_passage = '';}
        echo $this->Form->checkbox("cfpassage",["checked"=>$checked_passage,'label'=>'Passage de grade']); ?>Passage de grade
   
    </div>
    

    <div id="competitionblock" <?php if($article['competition'] == null) { echo 'style="display:none;"';}?>>


        <p class="center padding-3">Discipline :


            <?php echo $this->Form->input('competition.discipline_id', ['label' => false, 'class'=>'associated width-100 center',  [
        'options' => $disciplines]]);?>

        </p>




        <p class="center padding-3">Description :
            <?php echo $this->Form->input("competition.description", ['type'=>'textarea','class'=>'width-100','label'=>false]); ?>
        </p>

        <p class="center padding-3">Catégories :

            <p class="clear"></p>

            <p class="center padding-1">
                <?php echo $this->Form->input('competition.categories._ids', ['label' => false,'multiple'=>'true', 'class'=>'associated width-100 center',  [
        'options' => $categories]]);?>
            </p>

            <p class="center padding-3">Competitions en équipe ?
                <?php if($article['competition']['equipe'] > 0){$default = '1';} else {$default = 2;}?>
                <?php echo $this->Form->radio("cf_equipe",['1'=>'Oui','2'=>'Non'],['default'=>$default]); ?>

            </p>


            <div id="nombreequipe" class="center padding-3" <?php if($article['equipe'] > 0) { echo 'style="display:none;"';}?>>
                <p class="center"> Nombre de participants par équipes (pensez aux éventuels remplaçants):<br /><br />
                    <?php echo $this->Form->input("competition.equipe", ['type'=>'number','label'=>false]); ?>
                </p>
            </div>

            <p class="center padding-3">Date limite des inscriptions
                <?php echo $this->Form->input("date_desactivation", ['type'=>'text','id'=>'datelimite','label'=>false]); ?>
            </p>

            <?php echo $this->Html->scriptStart(['block' => true]);?>

            $('#datelimite').datepicker({ dateFormat: 'dd/mm/yy',

            });
            <?php $this->Html->scriptEnd(); ?>


            <p class="center padding-3">Réglement de la compétition :
                <?php echo $this->Form->input("competition.documentf", ['type'=>'file','label'=>false]); ?>
            </p>

    </div>

    <div class="center">
        <?php echo '<p class="center padding-3">'.$this->Form->button('Envoyer', ['type' => 'submit', 'name'=>'envoyer', 'class' => 'soumettre normalButton']);?>

    </div>


    <?php echo $this->Form->end();?>



</div>



<p class="center padding-3"></p>

<?php 
 $this->Html->css('chosen.min', ['block' => true]); ?>




<?php $this->Html->script('chosen.jquery', ['block' => true]); ?>


<?php // Chosen plug-in 
$this->Html->css('chosen.min', ['block' => true]); ?>


<?php $this->Html->script('chosen.jquery', ['block' => true]); ?>
<?php $this->Html->scriptStart(['block' => true]); ?>
(function($){
$('.associated').chosen({
no_results_text: "Il n'y a pas de catégorie avec ce nom",
width:"500px"
});
})(jQuery);


$('input[type=radio][name=cf_equipe]').change(function() {

if (this.value == '2') {
$('#nombreequipe').hide();
}
else if (this.value == '1') {
$('#nombreequipe').show();
}
});


$('#cfcompetition').click(function() {
$("#competitionblock").toggle(this.checked);

});

<?php $this->Html->scriptEnd(); ?>





<?php echo $this->Html->script('tinymce/tiny_mce.js');?>
<?php echo $this->element('tinymce-default') ?>
