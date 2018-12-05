<html>
	<body>
		<p class="text-align:center; width:100%; margin-left:auto; margin-right:auto;">
    		<?= $this->Html->image('logo.png', ['width'=>'345','height'=>'49','alt'=>'Inscriptions','style' => 'display:table; width:40px; height:40px; margin-left:auto; margin-right:auto;', 'fullBase' => true]) ?>
 		</p>
		<h1 style="text-align:center;  color:darkred; font-size:1.5em;">Vos inscriptions au passage de grade</h1>
    
		<table style="width:80%; border-collapse: collapse; margin-left:auto; margin-right:auto">
    		<tr style="background-color:#ccc">
       			<th style="border: solid 1px grey; text-align:center;">N° licence</th>
                <th style="border: solid 1px grey; text-align:center;">Nom</th>
                <th style="border: solid 1px grey; text-align:center;">Prénom</th>
                <th style="border: solid 1px grey; text-align:center;">Sexe</th>
                <th style="border: solid 1px grey; text-align:center;">Année de naissance</th>
                <th style="border: solid 1px grey; text-align:center;">Discipline</th>
                <th style="border: solid 1px grey; text-align:center;">Grade actuel</th>
                <th style="border: solid 1px grey; text-align:center;">Grade présenté</th>     
    		</tr>
  
    <?php foreach($recapPassage as $value){ ?>  
    		<tr>
                <td style="border: solid 1px grey; text-align:center;"><?= $value->licency->numero_licence ?></td>
                <td style="border: solid 1px grey; text-align:center;"><?= $value->licency->nom ?></td>
                <td style="border: solid 1px grey; text-align:center;"><?= $value->licency->prenom ?></td>
                <td style="border: solid 1px grey; text-align:center;"><?= $value->licency->sexe ?></td>
                <td style="border: solid 1px grey; text-align:center;"><?= $value->licency->ddn ?></td>
                <td style="border: solid 1px grey; text-align:center;"><?= $value->passage->discipline->name ?></td>
                <td style="border: solid 1px grey; text-align:center;"><?= $value->licency->grade->name ?></td>
                <td style="border: solid 1px grey; text-align:center;"><?= $value->grade->name ?></td>
       		</tr>
    <?php } ?>   
    	</table>
    </body>
</html>