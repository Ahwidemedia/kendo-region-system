
<h1 class="padding-trois-pourcent">Mon tableau de bord</h1>



<div  id="tableau-de-bord"  class="soixante-dix blanc-soixante-dix padding-un-pourcent margin-right-3-pourcent paragraphe-margin float-right">



<h1><?php echo h($user->username) ;?></h1>


<?php
if(!empty($user->avatar)) {
echo $this->Html->image($user->avatar, ['id'=>'avatar', 'alt'=>'avatar', 'class'=>'vingt-six float-left padding-trois-pourcent']);
	}
	else {  echo $this->Html->image('site/no-avatar.jpg', ['alt'=>'avatar', 'class'=>'vingt-six float-left padding-trois-pourcent']); } ?>

<div class="padding-un-pourcent  trente float-left">
<p class="cinzel font-1">Niveau : <span class="bert brun">

 <?php 
if($statut_badge == 0) { echo 'Commis';}
elseif($statut_badge == '1'){ echo 'Chef de partie';}
elseif($statut_badge == '2'){ echo 'Second';}
elseif($statut_badge == '3'){ echo 'Chef';}
elseif($statut_badge == '4'){ echo 'Chef 1 étoile';}
elseif($statut_badge == '5'){ echo 'Chef 2 étoiles';}
elseif($statut_badge == '6'){ echo 'Chef 3 étoiles';}

;?>

</span></p>
<p class="cinzel font-1">Nombre d'articles publiés : <span class="bert brun"><?php echo $num_articles ;?></span></p>

</div>
<p class="float-right"><?php echo $this->Html->link( 'Modifier mon profil', ['action'=>'account'],['class'=>'bouton-gris']);?></p>

<p class="float-right" style="clear:right"><?php echo $this->Html->link( 'Modifier mon mot de passe', ['action'=>'change'],['class'=>'bouton-gris']);?></p>

<div class="clear-right soixante float-right">
<h2 class="margin-trente">Mes badges</h2>

<?php // Calcul des totaux et des badges ;

foreach($row['badges'] as $k => $article): 


 	if($article['badge_Produits'] != '1') {$grey_p = 'grey opacity ';} else {$grey_p = '';} ?>
<?php if($article['badge_Mondes'] != '1') {$grey_sm = 'grey opacity ';} else {$grey_sm = '';} ?>
<?php if($article['badge_Recettes'] != '1') {$grey_r = 'grey opacity ';} else {$grey_r = '';} ?>
<?php if($article['badge_Explorations'] != '1') {$grey_ex = 'grey opacity ';} else {$grey_ex = '';} ?>
<?php if($article['badge_Encyclopedies'] != '1') {$grey_e = 'grey opacity ';} else {$grey_e = '';} ?>
<?php if($article['badge_premium'] != '1') {$grey_premium = 'grey opacity ';} else {$grey_premium = '';} 

endforeach?>

<div class="pop-up trente margin-left-deux-pourcent blanc-soixante-dix border-dix margin-bottom-trente float-left">
<p class="center "><?php echo $this->Html->image('site/badge-produits.png', ['alt'=>'avatar', 'class'=>$grey_p.'  center  soixante']); ?>
</p>
<p class="<?php echo $grey_p; ?> center bert">Chercheur de saveurs</p>
<p class="center"><?php foreach($row['badges'] as $k => $article): echo $article['num_Produits']; endforeach; if($row['badges'][0]['num_Produits'] < '2') { echo ' article';} else { echo ' articles';} ?></p>
<span>Ecrivez 5 articles dans l'abécédaire des produits</span>

</div>

<div class="pop-up trente margin-left-deux-pourcent blanc-soixante-dix border-dix margin-bottom-trente float-left">
<p class="center"><?php echo $this->Html->image('site/badge-mondes.png', ['alt'=>'avatar', 'class'=>$grey_sm.' center soixante']); ?></p>
<p class="<?php echo $grey_sm; ?> center bert">Globe Cooker</p>
<p class="center"><?php foreach($row['badges'] as $k => $article): echo $article['num_Mondes']; endforeach; if($row['badges'][0]['num_Mondes'] < '2') { echo ' suggestion';} else { echo ' suggestions';} ?> </p>
<span>Ecrivez 5 articles dans l'encyclopédie monde</span>
</div>

<div class="pop-up trente margin-left-deux-pourcent blanc-soixante-dix border-dix margin-bottom-trente  float-left">
<p class="center"><?php echo $this->Html->image('site/badge-explorations.png', ['alt'=>'avatar', 'class'=>$grey_ex.' center soixante']); ?>
</p>
<p class="<?php echo $grey_ex; ?>center bert">Flâneur gourmand</p>
<p class="center"><?php foreach($row['badges'] as $k => $article): echo $article['num_Explorations']; endforeach; if($row['badges'][0]['num_Explorations'] < '2') { echo ' article';} else { echo ' articles';} ?></p>
<span>Ecrivez 5 articles dans les explorations gourmandes</span>

</div>

<div class="pop-up trente margin-left-deux-pourcent blanc-soixante-dix border-dix margin-bottom-trente  float-left">
<p class="center"><?php echo $this->Html->image('site/badge-encyclopedies.png', ['alt'=>'avatar', 'class'=>$grey_e.' center soixante']); ?>
</p>
<p class="<?php echo $grey_e; ?>center bert">Exégète gourmet</p>
<p class="center"><?php foreach($row['badges'] as $k => $article): echo $article['num_Encyclopedies']; endforeach; if($row['badges'][0]['num_Encyclopedies'] < '2') { echo ' article';} else { echo ' articles';} ?></p>

<span>Ecrivez 5 articles dans l'encyclopédie</span>

</div>

<div class="pop-up trente margin-left-deux-pourcent blanc-soixante-dix border-dix margin-bottom-trente  float-left">
<p class="center"><?php echo $this->Html->image('site/badge-recettes.png', ['alt'=>'avatar', 'class'=>$grey_r.' center soixante']); ?>
</p>
<p class="<?php echo $grey_r; ?> center bert">Epicurien aux fourneaux</p>
<p class="center"><?php foreach($row['badges'] as $k => $article): echo $article['num_Recettes']; endforeach; if($row['badges'][0]['num_Recettes'] < '2') { echo ' recette';} else { echo ' recettes';} ?></p>
<span>Ecrivez 5 recettes</span>


</div>

<div class="pop-up trente margin-left-deux-pourcent blanc-soixante-dix border-dix margin-bottom-trente  float-left"> 
<p class="center">
<?php echo $this->Html->image('site/badge-premium.png', ['alt'=>'avatar', 'class'=>$grey_premium.'center soixante']); ?>
</p><p class="<?php echo $grey_premium; ?>center bert">Maître-queue</p>
<p class=" center"><?php echo $num_premium; if($num_premium < '2') { echo ' article';} else { echo ' articles';} ?></p>
<span>Obtenez les 5 autres badges et écrivez au moins 10 articles premium</span>

</div>



<div class="clear margin-trente"></div>
</div>
<div>
<div class="clear margin-trente"></div>
<h2 class="margin-trente">Mes recettes favories</h2>

<?php foreach($row['favories'] as $k => $article): ?>
	

<div class="bloc-recette" class="margin-trente padding-un-pourcent quatre-vingt-dix center blanc-soixante-dix border-dix">

 <?php if(!empty($article['recette']['illustration'])) { echo $this->Html->image('illustrations/recettes/'.$article['recette']['id'].'/m-'.$article['recette']['illustration'], [ "alt" => h($article['recette']['name']),  "class" => "float-left vingt margin-dix margin-right-trente border-dix"]); }
   else {echo $this->Html->image('site/no-image.jpg', ['alt'=> 'Pas d\'icone', 'class' => 'float-left vingt margin-dix margin-right-trente']);}?>

<p class="cinzel margin-dix"><?php echo $this->Html->link($article['recette']['name'],['controller'=>'Recettes','action'=>'show',$article['recette']['id'],$article['recette']['slug']]) ;?></p>


<div class=" quatre-vingt" style="margin-left:auto;">

<div class="float-left trente">
<p><span class="bert">Temps de préparation :</span> <?php echo h($article['recette']['preparation']);?></p>
<p class="margin-top-dix"><span class="bert">Temps de cuisson :</span> <?php if(!empty($article['recette']['cuisson'])){echo h($article['recette']['cuisson']);} else {echo 'N/A';}?></p>

<p class="margin-top-dix"><span class="bert">Catégorie :</span> <?php echo h($article['recette']['recettecategory']['name']);?></p>
</div>


<div class="float-right vingt-deux">

<p class="center"><span class="bert">Difficulté:</span></p>
<?php if($article['recette']['difficulte'] == '1') {
echo $this->Html->image('site/logo1.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
}elseif($article['recette']['difficulte'] == '2') {
echo $this->Html->image('site/logo1.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo1.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
}
elseif($article['recette']['difficulte'] == '3'){
echo $this->Html->image('site/logo2.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'logo', 'class'=>'icon-presentation center']);
} ?>
</div>

<div class="float-right vingt-trois">
<p class="center"><span class="bert">Coût:</span></p> <?php if($article['recette']['cout'] == '1') {
echo $this->Html->image('site/euro1.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
}elseif($article['recette']['cout'] == '2') {
echo $this->Html->image('site/euro1.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro1.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
}
elseif($article['recette']['cout'] == '3') {
echo $this->Html->image('site/euro2.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'euro', 'class'=>'icon-presentation center']);
} ?>
</div>

<p class="clear-right padding-top-trois-pourcent"> </p>
<p class="cent margin-top-trente"><span class="bert"><?php echo h($article['recette']['recette']['description']);?>
</p></div> </div>
<?php endforeach;?>



</div>
<div class="clear"> </div>



</div>


<div class="margin-left-deux-pourcent vingt-trois float-left">

<div id="bloc-utilisateur">
<ul><li>
<?php echo $this->Html->image('site/ico-recettes.png', ['alt'=>'Recettes', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Mes recettes</span>
</li>

<?php foreach($row['recettes'] as $k => $article):

echo '<li style="padding-right:30px">';

	if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'soumis',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{ echo $this->Html->image("site/statut-refuse.png", ["title"=>'refuse',  "alt" => "Refuse", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 3)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'enligne',  "alt" => "En ligne", "class" => "notif float-left float-left"]);}
	else
	{echo $this->Html->image("site/statut-premium.png", ["title"=>'premium', "alt" => "Premium", "class" => "notif float-left float-left"]);}
	
if(!empty($article->illustration)){
echo $this->html->image('illustrations/'.$article->user_id.'/s-'.$article['illustration'], ['alt'=>'icone '.h($article->name).'', 'class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Recettes','action'=>'show',$article->id]);
if($article['statut'] == 0 OR $article['statut'] == 2 ){

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Recettes','action'=>'edit',$article->id]]);
}

echo '</li>';
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Recettes', 'action'=>'index'],['class'=>'bert padding-un-pourcent']);?>
</li>
</ul><ul>

<li>
<?php echo $this->Html->image('site/ico-produit.png', ['alt'=>'Produits', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Mes articles produits</span>
</li>


<?php foreach($row['produits'] as $k => $article):

echo '<li>';

if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'soumis',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{ echo $this->Html->image("site/statut-refuse.png", ["title"=>'refuse',  "alt" => "Refuse", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 3)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'enligne',  "alt" => "En ligne", "class" => "notif float-left float-left"]);}
	else
	{echo $this->Html->image("site/statut-premium.png", ["title"=>'premium', "alt" => "Premium", "class" => "notif float-left float-left"]);}
	
	
if(!empty($article->illustration)){
echo $this->html->image('illustrations/produits/'.$article->id.'/s-'.$article['illustration'], ['alt'=>'icone '.h($article->name).'','class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Produits','action'=>'show',$article->id]);
if($article['statut'] < 3){

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Produits','action'=>'edit',$article->id]]);
}

echo '</li>';
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Produits', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


<ul>

<li>
<?php echo $this->Html->image('site/ico-encyclo.png', ['alt'=>'Encyclopedie', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Mes articles de l'Encyclopédie</span>
</li>


<?php foreach($row['encyclopedies'] as $k => $article):

echo '<li>';

if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'soumis',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{ echo $this->Html->image("site/statut-refuse.png", ["title"=>'refuse',  "alt" => "Refuse", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 3)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'enligne',  "alt" => "En ligne", "class" => "notif float-left float-left"]);}
	else
	{echo $this->Html->image("site/statut-premium.png", ["title"=>'premium', "alt" => "Premium", "class" => "notif float-left float-left"]);}
	
	
if(!empty($article->illustration)){
echo $this->html->image('illustrations/encyclopedies/'.$article->id.'/s-'.$article['illustration'], ['class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Encyclopedies','action'=>'show',$article->id]);
if($article['statut'] < 3){
echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Encyclopedies','action'=>'edit',$article->id,$article->encyclopediecategory_id]]);
}

echo '</li>';
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Encyclopedies', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


<ul>

<li>
<?php echo $this->Html->image('site/ico-liens.png', ['alt'=>'Explorations gourmandes', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Mes Explorations gourmandes</span>
</li>


<?php foreach($row['explorations'] as $k => $article):

echo '<li>';

if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'soumis',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{ echo $this->Html->image("site/statut-refuse.png", ["title"=>'refuse',  "alt" => "Refuse", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 3)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'enligne',  "alt" => "En ligne", "class" => "notif float-left float-left"]);}
	else
	{echo $this->Html->image("site/statut-premium.png", ["title"=>'premium', "alt" => "Premium", "class" => "notif float-left float-left"]);}
	
	
if(!empty($article->illustration)){
echo $this->html->image('illustrations/explorations/'.$article->id.'/s-'.$article['illustration'], ['alt'=>'icone '.h($article->name).'','class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Explorations','action'=>'show',$article->id]);
if($article['statut'] < 3){
echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Explorations','action'=>'edit',$article->id,$article['explorationcategory_id']]]);
}

echo '</li>';
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Explorations', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


<ul>

<li>
<?php echo $this->Html->image('site/ico-monde.png', ['alt'=>'Mondes', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Mes contributions aux pays</span>
</li>


<?php  foreach($row['sujet_mondes'] as $k => $article):
echo '<li>';

	if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'Réponse envoyée',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'Réponse',  "alt" => "Réponse", "class" => "notif float-left float-left"]);}
	
	
echo $this->html->image($article['monde']['drapeau'], ['class'=>'icon']);

echo $this->html->link($article['monde']['name'],['controller'=>'Mondes','action'=>'review',$article['monde']['id'],'2',$article['id']]);

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Mondes','action'=>'review',$article['monde']['id'],'2',$article['id']]]);


echo '</li>';
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir toutes les contributions...', ['controller'=>'Mondes', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


</div>
<p class="clear"></p>
</div>



<div class="clear margin-30"> </div>


	          
        <?php echo $this->Html->scriptStart(['block' => true]);?>

$(".supprimer").easyconfirm({locale: {
	title: 'Etes-vous sûr(e) ?',
	text: 'L\'élément sélectionné sera définitivement supprimé.',
	button: ['Annuler',' Confirmer'],
	closeText: 'fermer'
}});

<?php $this->Html->scriptEnd(); ?>
