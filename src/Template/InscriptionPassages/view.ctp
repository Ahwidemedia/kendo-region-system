<div class="width-100 center">
	<h1 class="center">Inscriptions au passage de grade</h1>
	<p align="center"><?= $this->Html->link("Retour", ['controller'=>'InscriptionPassages','action'=>'resume', $event->id],['class'=>'btn btn-default']) ?></p>
	
    <div class="center width-70">
        <h2 class="center black margin-top-50-px ">Inscriptions</h2>
		<table class="tableau-gris" style="margin-top:5px; border:solid 3px black" id="tabInscription">
            <tr>
                <td>Discipline</td>
                <td><?= $inscription->passage->discipline->name ?>
            </tr>
            <tr>
                <td>Numero de licence</td>
                <td><?= $inscription->licency->numero_licence ?>
            </tr>
            <tr>
                <td>Nom</td>
                <td><?= $inscription->licency->nom ?>
            <tr>
                <td>Prénom</td>
                <td><?= $inscription->licency->prenom ?>
            </tr>
            <tr>
                <td>Sexe</td>
                <td><?= $inscription->licency->sexe ?>
            <tr>
            <tr>
                <td>Nationalité</td>
                <td><?= $inscription->licency->nationalite ?>
            </tr>
            <tr>
                <td>Adresse</td>
                <td><?= $inscription->licency->adresse ?>
            </tr>
            <tr>
                <td>Téléphone</td>
                <td><?= $inscription->licency->telephone ?>
            </tr>
            <tr>
                <td>Fax</td>
                <td><?= $inscription->licency->fax ?>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= $inscription->licency->email ?>
            </tr>
            <tr>
                <td>Date de naissance</td>                
                <td><?= $inscription->licency->date_naissance ?>
            </tr>
            <tr>
                <td>Lieu de naissance</td>
                <td><?= $inscription->licency->lieu_naissance ?>
            </tr>
            <tr>
                <td>Grade précédent</td>
                <td><?= $inscription->licency->grade->name ?>
            </tr>
            <tr>
                <td>Obtenu le</td>
                <td><?= $inscription->licency->grade_actuel_date ?>
            </tr>
            <tr>
                <td>Lieu d'obtention</td>
                <td><?= $inscription->licency->grade_actuel_lieu ?>
            </tr>
            <tr>
                <td>Organisation</td>
                <td><?= $inscription->licency->grade_actuel_organisation ?>
            </tr>
            <tr>
                <td>Grade présenté</td>
                <td><?= $inscription->grade->name ?>
            </tr>            
        </table>
	</div>
	
	<?= $this->Html->link("Exporter en pdf", ['action'=>'fiche',$id,'vertical', '_ext' => 'pdf'],[ 'class'=>'center normalButton margin-3']);?>

</div>
        