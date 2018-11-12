<div class="padding-50">
<h1>Panneau de contrôle des Administrateurs</h1>


<div class="blanc-soixante-dix padding-trois-pourcent margin-dix">
<h2>Gestion des utilisateurs</h2>
<table class="tableau-gris">
<tr>
	<th>Login</th>
	<th>Nom</th>
	<th>Role</th>
	<th>Date d'inscription</th>
	<th>Action</th>
	</tr>
	<?php foreach($users as $user): ?>
	<tr>
	
	<td><?php echo $this->Html->link($user->username, ['action'=>'profile',$user->id,'prefix'=>false]);?></td>
	<td><?php echo h($user->lastname).' '.h($user->firstname); ?></td>
	<td><?php echo h($user->role); ?></td>
	<td><?php echo h($user->created); ?></td>
	<td>
	<?php echo $this->Html->link("Editer", ['action'=>'edit',$user->id]);?>
	 | 
	<?php $token = md5($user->username);
	
	echo $this->Html->link("Supprimer", ['action'=>'delete', $user->id,$token], ['class'=>'supprimer']); ?>

	
	</td></tr>
	<?php endforeach; ?>
	</table>
	
	<p class="right"><?php echo $this->Html->link("Ajouter un utilisateur", ['action'=>'add'], ['class'=>'bouton-gris margin-dix']); ?></p>



</div>
        
<?php echo $this->Html->scriptStart(['block' => true]);?>

$(".supprimer").easyconfirm({locale: {
	title: 'Etes-vous sûr(e) ?',
	text: 'L\'élément sélectionné sera définitivement supprimé.',
	button: ['Annuler',' Confirmer'],
	closeText: 'fermer'
}});

<?php $this->Html->scriptEnd(); ?>

	
