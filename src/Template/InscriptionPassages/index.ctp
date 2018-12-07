<?php 
$conn = $this->request->session()->read('Auth.User');
echo $this->Html->link("Retour", ['controller'=>'inscriptions','action'=>'index'],[ 'class'=>'absolute top-right']);
//debug($inscription);die;
?>

<div class="width-100 center">
	<h1 class="center">Inscriptions au passage de grade</h1>
	<?= $this->Form->create(null) ?>
    <p class="center margin-top-50-px">Sélectionner votre club :
        <?= $this->Form->input('club_id', ['label' => false, 'class'=>'associated center', 'value'=> $conn['club_id'], ['options' => $clubs, ]]) ?>
    </p>

    <p class="center padding-1">
        <?= $this->Form->checkbox("new_club",['onchange'=>"newclub(this)"] ); ?>Je ne trouve pas mon club, je veux l'ajouter dans la liste.</p>

    <div class="newclub center display-none">
        <p class="center">Nom du club : </p>
        <?= $this->Form->input("club_name", ['type'=>'text','value'=>'','label'=>false]) ?>        
        <?= $this->Form->input('region_id', ['label' => false, 'class'=>'center',  ['options' => $regions]]) ?>
    </div>

    <div class="center width-70">
        <h2 class="center black margin-top-50-px ">Inscriptions</h2>
        <table class="tableau-gris" style="margin-top:5px; border:solid 3px black" id="tabInscription">
            <tr>
                <td>Numero de licence</td>
                <td><?= $this->Form->text("numero_licence",['numero_licence' => 'numero_licence','label' => false, 'class'=>'nom-ind','style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->licency->numero_licence.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Nom</td>
                <td><?= $this->Form->text("nom",['name' => 'nom','label' => false, 'class'=>'nom-ind','style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->licency->nom.'"' : '']) ?></td>
            <tr>
                <td>Prénom</td>
                <td><?= $this->Form->text("prenom",['name' => 'prenom','label' => false, 'class'=>'prenom-ind','style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->licency->prenom.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Sexe</td>
                <td><?= $this->Form->input('sexe', ['label' => false,'id'=>'sexe',
														   	'div' => false,
															'class' => 'sex-ind', 
                    										'options'=>[''=>'','F'=>'F','H'=>'H'],
                    ($inscription) ? 'value="'.$inscription->licency->prenom.'"' : '']); ?></td>
            <tr>
            <tr style="border-top:solid 3px black; ">
                <td>Nationalité</td>
                <td><?= $this->Form->text("nationalite", ['name' => 'nationalite','label' => false, 'class'=>'nationalite-ind','style'=>'width:80%; height:2em', ($inscription) ? 'value="'.$inscription->licency->nationalite.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Adresse</td>
                <td><?= $this->Form->text("adresse",[ 'name' => 'adresse','label' => false,'style'=>'width:80%; height:2em', 'class'=>'adresse-ind', ($inscription) ? 'value="'.$inscription->licency->adresse.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Téléphone</td>
                <td><?= $this->Form->text("telephone", ['name' => 'telephone','label' => false, 'class'=>'telephone-ind','style'=>'width:80%; height:2em', ($inscription) ? 'value="'.$inscription->licency->telephone.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Fax</td>
                <td><?= $this->Form->input("fax", ['name' => 'fax','label' => false, 'class'=>'fax-ind', 'style'=>'width:80%; height:2em', ($inscription) ? 'value="'.$inscription->licency->fax.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= $this->Form->input("email", ['name' => 'email','label' => false, 'class'=>'email-ind', 'style'=>'width:80%; height:2em', ($inscription) ? 'value="'.$inscription->licency->email.'"' : '']) ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td>Date de naissance</td>
                <td><?= $this->Form->input("date_naissance", ['name' => 'date_naissance','label' => false, 'class'=>'ddn-ind', 'style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->licency->date_naissance.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Lieu de naissance</td>
                <td><?= $this->Form->input("lieu_naissance", ['name' => 'lieu_naissance','label' => false, 'class'=>'ldn-ind', 'style'=>'width:80%; height:2em', ($inscription) ? 'value="'.$inscription->licency->lieu_naissance.'"' : '']) ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td>Grade précédent</td>
                <td><?= $this->Form->input("grade_id", ['name' => 'grade_id','label' => false, 'class'=>'grade-ind', 'style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->licency->grade_id.'"' : '',  ['options' => $grades]]) ?></td>
            </tr>
            <tr>
                <td>Obtenu le</td>
                <td><?= $this->Form->input("grade_actuel_date", ['name' => 'grade_actuel_date','label' => false, 'class'=>'obteny-ind', 'style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->licency->grade_actuel_date.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Lieu d'obtention</td>
                <td><?= $this->Form->input("grade_actuel_lieu", ['name' => 'grade_actuel_lieu','label' => false, 'class'=>'lieu-obtention-ind', 'style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->licency->grade_actuel_lieu.'"' : '']) ?></td>
            </tr>
            <tr>
                <td>Organisation</td>
                <td><?= $this->Form->input("grade_actuel_organisation", ['name' => 'grade_actuel_organisation','label' => false, 'class'=>'organisation-ind', 'style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->licency->grade_actuel_organisation.'"' : '']) ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td>Grade présenté</td>
                <td><?= $this->Form->input("grade_id", ['name' => 'grade_presente_id','label' => false, 'class'=>'grade-ind', 'style'=>'width:80%; height:2em', 'required' => true, ($inscription) ? 'value="'.$inscription->grade_presente_id.'"' : '',  ['options' => $grades]]) ?></td>
            </tr>            
        </table>
        <div class="center padding-3">
            <table class="width-100 tableau-gris">
                <tbody>
                    <tr>
                        <td><p><strong>Grade pr&eacute;sent&eacute;</strong></p></td>
                        <td><p><strong>D&eacute;lai entre les grades</strong></p></td>
                        <td><p><strong>Frais d&rsquo;inscription</strong></p><p><strong>&agrave; r&eacute;gler sur place</strong></p></td>
                        <td><p><strong>Frais d&rsquo;enregistrement</strong></p><p><strong>&agrave; r&eacute;gler apr&egrave;s obtention</strong></p></td>
                    </tr>
                    <tr>
                        <td><p>1 dan</p></td>
                        <td><p>(3 timbres de licences)</p></td>
                        <td><p>15 Euros</p></td>
                        <td><p>15 Euros</p></td>
                    </tr>
                    <tr>
                        <td><p>2 dan</p></td>
                        <td><p>1 an</p></td>
                        <td><p>25 Euros</p></td>
                        <td><p>25 Euros</p></td>
                    </tr>
                    <tr>
                        <td><p>3 dan</p></td>
                        <td><p>2 ans</p></td>
                        <td><p>35 Euros</p></td>
                        <td><p>35 Euros</p></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <p class="center padding-3"></p>
        <p class="margin-top-3 center">
            Avez-vous un commentaire à ajouter à votre inscription ? <br />
            <?php echo $this->Form->input("commentaire", ['type'=>'textarea','class'=>'width-80 center','label'=>false]); ?>

        </p>
        <p class="margin-top-3 center width-50">
            <?php echo $this->Form->checkbox("consent", ['class'=>'consent','label'=>false]); ?>
            En soumettant ce formulaire, j'accepte que les informations saisies soient exploitées dans le cadre de l'orgaisation de la compétition.
        </p>


        <div class="margin-top-3 center ">
            <?= '<p class="center">'.$this->Form->button('Envoyer', ['disabled'=>'disabled', 'type' => 'submit', 'name'=>'envoyer', 'class' => 'soumettre normalButton']) ?>

        </div>

        <?= $this->Form->end() ?>
        <?= $this->fetch('postLink');?>
       
	</div>
</div>


<?php  $this->Html->scriptStart(['block' => true]); ?>


function newclub(x) { if($(x).is(':checked')) { $(".newclub").addClass("display-block"); } } 
      
$('.consent').click(function() {
	if (this.checked) {
		$(this).parent().next().children().eq(0).children().eq(0).prop('disabled', false);   
	} else {        
       	$(this).parent().next().children().eq(0).children().eq(0).prop('disabled', true);       
    }
});

$(".soumettre").easyconfirm({locale: {
	title: 'Etes-vous sûr(e)?',
    text: "Voulez-vous envoyer vos inscriptions ?<br /><br /> Assurez vous d'avoir bien rempli toutes les colonnes avant l'envoi.",
    button: ['Annuler',' Confirmer'],
    closeText: 'fermer'
    }
});
<?php $this->Html->scriptEnd(); ?>