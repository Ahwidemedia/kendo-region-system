<html>
	<body>
		<p class="text-align:center; width:100%; margin-left:auto; margin-right:auto;">
    		<?= $this->Html->image('logo.png', ['width'=>'345','height'=>'49','alt'=>'Inscriptions','style' => 'display:table; width:40px; height:40px; margin-left:auto; margin-right:auto;', 'fullBase' => true]) ?>
 		</p>
		<h1 style="text-align:center;  color:darkred; font-size:1.5em;">Récapitulatif de votre inscription au passage de grade</h1>

    	
    	
        <table class="tableau-gris" style="margin-top:5px; border:solid 3px black" id="tabInscription">
        <caption>Informations transmises</caption>
        	<tr>        	
                <td>Discipline</th>
                <td><?= $value->passage->discipline->name ?></td>
        	</tr>
            <tr>
                <td>Numero de licence</td>
                <td><?= $recapPassage->licency->numero_licence ?></td>
            </tr>
            <tr>
                <td>Nom</td>
                <td><?= $recapPassage->licency->nom?></td>
            <tr>
                <td>Prénom</td>
                <td><?= $recapPassage->licency->prenom ?></td>
            </tr>
            <tr>
                <td>Sexe</td>
                <td><?= $recapPassage->licency->sexe ?></td>
            <tr>
            <tr style="border-top:solid 3px black; ">
                <td>Nationalité</td>
                <td><?= $recapPassage->licency->nationalite ?></td>
            </tr>
            <tr>
                <td>Adresse</td>
                <td><?= $recapPassage->licency->adresse ?></td>
            </tr>
            <tr>
                <td>Téléphone</td>
                <td><?= $recapPassage->licency->telephone ?></td>
            </tr>
            <tr>
                <td>Fax</td>
                <td><?= $recapPassage->licency->fax ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= $recapPassage->licency->email ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td>Date de naissance</td>
                <td><?= $recapPassage->licency->date_naissance ?></td>
            </tr>
            <tr>
                <td>Lieu de naissance</td>
                <td><?= $recapPassage->licency->lieu_naissance ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td>Grade précédent</td>
                <td><?= $recapPassage->licency->grade->name ?></td>
            </tr>
            <tr>
                <td>Obtenu le</td>
                <td><?= $recapPassage->grade_actuel_date ?></td>
            </tr>
            <tr>
                <td>Lieu d'obtention</td>
                <td><?= $recapPassage->licency->grade_actuel_lieu ?></td>
            </tr>
            <tr>
                <td>Organisation</td>
                <td><?= $recapPassage->licency->grade_actuel_organisation ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td>Grade présenté</td>
                <td><?= $recapPassage->grade->name ?></td>
            </tr>
        </table>
    </body>
</html>