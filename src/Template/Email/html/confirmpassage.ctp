<html>
	<body>
		<p class="text-align:center; width:100%; margin-left:auto; margin-right:auto;">
    		<?= $this->Html->image('logo.png', ['width'=>'345','height'=>'49','alt'=>'Inscriptions','style' => 'display:table; width:40px; height:40px; margin-left:auto; margin-right:auto;', 'fullBase' => true]) ?>
 		</p>
		<h1 style="text-align:center;  color:darkred; font-size:1.5em;">Récapitulatif de votre inscription au passage de grade</h1>

    	
    	
        <table style="margin-top:5px;width:80%; margin-left:auto; margin-right:auto; border:solid 3px black" id="tabInscription">
        <caption>Informations transmises</caption>
        	<tr>        	
                <td style="border:solid 1px grey; padding:5px">Discipline</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->passage->discipline->name ?></td>
        	</tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Numero de licence</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->numero_licence ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Nom</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->nom?></td>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Prénom</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->prenom ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Sexe</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->sexe ?></td>
            <tr>
            <tr style="border-top:solid 3px black; ">
                <td style="border:solid 1px grey; padding:5px">Nationalité</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->nationalite ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Adresse</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->adresse ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Téléphone</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->telephone ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Fax</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->fax ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Email</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->email ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td style="border:solid 1px grey; padding:5px">Date de naissance</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->date_naissance ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Lieu de naissance</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->lieu_naissance ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td style="border:solid 1px grey; padding:5px">Grade précédent</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->grade->name ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Obtenu le</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->grade_actuel_date ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Lieu d'obtention</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->grade_actuel_lieu ?></td>
            </tr>
            <tr>
                <td style="border:solid 1px grey; padding:5px">Organisation</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->licency->grade_actuel_organisation ?></td>
            </tr>
            <tr style="border-top:solid 3px black; ">
                <td style="border:solid 1px grey; padding:5px">Grade présenté</td>
                <td style="border:solid 1px grey; padding:5px"><?= $recapPassage->grade->name ?></td>
            </tr>
        </table>
    </body>
</html>