

$(".enligne").easyconfirm({locale: {
	title: 'Etes-vous sûr(e)?',
	text: 'Votre article sera désormais en ligne et visible par tous.',
	button: ['Annuler',' Confirmer'],
	closeText: 'fermer'
}});



$(".refuse").easyconfirm({locale: {
	title: 'Etes-vous sûr(e) ?',
	text: 'L\'article de l\'utilisateur lui sera renvoyé avec la mention "refusée."',
	button: ['Annuler',' Confirmer'],
	closeText: 'fermer'
}});

