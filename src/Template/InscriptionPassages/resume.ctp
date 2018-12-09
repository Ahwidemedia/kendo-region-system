<?php 

$conn = $this->request->session()->read('Auth.User');

echo $this->Html->link("Retour", ['controller'=>'Pages','action'=>'index'],[ 'class'=>'absolute top-right']);
echo $this->Html->link("Modifier les données de l'évenement", ['controller'=>'Evenements','action'=>'creation',$event['id']],[ 'class'=>'float-right']);

?>


<div class="width-100 center">
    <h1 class="center">Inscriptions au passage de grade</h1>
    <div class="center width-90">
		<table class="tableau-gris" id="addelement-table">
            <thead>
                <tr>
                    <th>N° licence</th>
                    <th style="min-width:100px">Nom</th>
                    <th style="min-width:100px">Prénom</th>
                    <th>Sexe</th>
                    <th>Grade</th>
                    <th>Date de naissance</th>
                    <th>Club</th>
                    <th>Grade présenté</th>
                    <th class="action"></th>
                </tr>
            </thead>

            <tbody>
            <?php foreach ($inscriptions as $value) {?>
            	<tr>
            		<td><?= $value->licency->numero_licence ?></td>
            		<td><?= $value->licency->nom ?></td>
            		<td><?= $value->licency->prenom ?></td>
            		<td><?= $value->licency->sexe ?></td>
            		<td><?= $value->licency->grade->name ?></td>
            		<td><?= $value->licency->date_naissance ?></td>
            		<td><?= $value->licency->club->name ?></td>
            		<td><?= $value->grade->name ?></td>
            		<td><?= $this->Html->link("Voir", ['controller'=>'InscriptionPassages','action'=>'view', $value->id]);
            		?></td>
            	</tr>
            <?php } ?> 

                
            </tbody>
        </table>
        <p class="center padding-3">
	<?= $this->Html->link("Exporter en excel", ['action'=>'export',$id, '_ext' => 'csv'],[ 'class'=>'center normalButton margin-3']);?>
	<?= $this->Html->link("Exporter en pdf", ['action'=>'view',$id, '_ext' => 'pdf'],[ 'class'=>'center normalButton margin-3']);?>
</p>
	</div>
</div>

