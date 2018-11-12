
<h1 class="padding-trois-pourcent">Interface Administrateur</h1>



<div id="etat-admin" class="padding-50 quarante center inline-block margin-deux-pourcent blanc-soixante-dix padding-un-pourcent paragraphe-margin ">


<h2 class="margin-bottom-trente">Nombres d'articles dans la base :</h2>

<?php  foreach($num_articles as $num_row): ?>


 <?php
    
    if(!empty($num_row['encyclopedies'][0]['total'])) {  echo	'<p class="bert center">Encyclopedies : '.$num_row['encyclopedies'][0]['total'].'</p>';}else{$num_row['encyclopedies'][0]['total'] = '0';}
    if(!empty($num_row['explorations'][0]['total'])) {  echo	'<p class="bert center">Explorations : '.$num_row['explorations'][0]['total'].'</p>';} else{$num_row['explorations'][0]['total'] = '0';}
	if(!empty($num_row['recettes'][0]['total'])) {  echo	'<p class="bert center">Recettes : '.$num_row['recettes'][0]['total'].'</p>';} else{$num_row['recettes'][0]['total'] = '0';}
	if(!empty($num_row['produits'][0]['total'])) {  echo	'<p class="bert center">Produits : '.$num_row['produits'][0]['total'].'</p>';} else{$num_row['produits'][0]['total'] = '0';}
	if(!empty($num_row['mondes'][0]['total'])) {  echo	'<p class="bert center">Mondes : '.$num_row['mondes'][0]['total'].'</p>';} else{$num_row['mondes'][0]['total'] = '0';}

 endforeach; ?>

<p class="center padding-trois-pourcent"><?php echo $this->Html->link( 'Gestion des utilisateurs', ['action'=>'utilisateurs'],['class'=>'bouton-gris']);?></p>

<p class="center padding-trois-pourcent"><?php echo $this->Html->link( 'Modifier mon profil', ['action'=>'account','prefix'=>false],['class'=>'bouton-gris']);?></p>

<p class="center padding-trois-pourcent"><?php echo $this->Html->link( 'Modifier mon mot de passe', ['action'=>'change','prefix'=>false],['class'=>'bouton-gris']);?></p>

<p class="center padding-trois-pourcent"><?php echo $this->Html->link( 'Aller sur l\'Interface personnel', ['action'=>'accueil'],['class'=>'cinzel font-1 blanc margin-top-trente']);?></p>


</div>

<div class="margin-deux-pourcent margin-right-3-pourcent vingt-trois float-left">

<div id="bloc-utilisateur">
<ul><li>
<?php echo $this->Html->image('site/ico-recettes.png', ['alt'=>'Produits', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Dernières recettes</span>
</li>

<?php  foreach($query as $article):

foreach($article['recettes'] as $k => $article):

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
echo $this->html->image('illustrations/recettes/'.$article['id'].'/s-'.$article['illustration'], ['class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Recettes','action'=>'show', 'prefix'=> false,$article->id]);

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Recettes','action'=>'edit',$article->id]]);


echo '</li>';
endforeach;
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Recettes', 'action'=>'index'],['class'=>'bert padding-un-pourcent']);?>
</li>
</ul><ul>

<li>
<?php echo $this->Html->image('site/ico-produit.png', ['alt'=>'Produits', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Derniers produits</span>
</li>


<?php  foreach($query as $article):

foreach($article['produits'] as $k => $article):


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
echo $this->html->image('illustrations/produits/'.$article->id.'/s-'.$article['illustration'], ['class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Produits','action'=>'show', 'prefix'=> false,$article->id]);


echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Produits','action'=>'edit',$article->id]]);


echo '</li>';
endforeach;
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Produits', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


<ul>

<li>
<?php echo $this->Html->image('site/ico-encyclo.png', ['alt'=>'Produits', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Derniers articles de l'Encyclopédie</span>
</li>


<?php  foreach($query as $article):

foreach($article['encyclopedies'] as $k => $article):

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

echo $this->html->link($article['name'],['controller'=>'Encyclopedies','action'=>'show', 'prefix'=> false,$article->id]);

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Encyclopedies','action'=>'edit',$article->id,$article->encyclopediecategory_id]]);


echo '</li>';
endforeach;
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Encyclopedies', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


<ul>

<li>
<?php echo $this->Html->image('site/ico-liens.png', ['alt'=>'Produits', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Dernières Explorations gourmandes</span>
</li>


<?php 
foreach($query as $article):

foreach($article['explorations'] as $k => $article):

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
echo $this->html->image('illustrations/explorations/'.$article->id.'/s-'.$article['illustration'], ['class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Explorations','action'=>'show', 'prefix'=> false,$article->id]);
echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Explorations','action'=>'edit',$article->id,$article['explorationcategory_id']]]);


echo '</li>';
endforeach;
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Explorations', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>



</div>
<p class="clear"></p>
</div>

<div class="margin-deux-pourcent vingt-trois float-right">

<div id="bloc-utilisateur">

<ul><li>
<?php echo $this->Html->image('site/ico-news.png', ['alt'=>'Produits', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Derniers articles pays</span>
</li>


<?php 
foreach($query as $article):
foreach($article['news'] as $k => $article):
echo '<li>';

	if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'Réponse envoyée',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'Réponse',  "alt" => "Réponse", "class" => "notif float-left float-left"]);}
	elseif ($article['statut'] == 3)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'enligne',  "alt" => "En ligne", "class" => "notif float-left float-left"]);}
	
if(!empty($article->illustration)){
echo $this->html->image('illustrations/'.$article->user_id.'/s-'.$article['illustration'], ['class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'news','action'=>'show', 'prefix'=> false,$article->id]);
echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'news','action'=>'edit',$article->id,$article['newcategory_id']]]);


echo '</li>';
endforeach;
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Mondes', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>

<ul><li>
<?php echo $this->Html->image('site/ico-monde.png', ['alt'=>'Produits', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Derniers articles pays</span>
</li>


<?php 
foreach($query as $article):
foreach($article['mondes'] as $k => $article):
echo '<li>';

	if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'Réponse envoyée',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'Réponse',  "alt" => "Réponse", "class" => "notif float-left float-left"]);}
	
	
echo $this->html->image($article['drapeau'], ['class'=>'icon']);

echo $this->html->link($article['name'],['controller'=>'Mondes','action'=>'review',$article['id']]);

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Mondes','action'=>'edit',$article['id']]]);


echo '</li>';
endforeach;
endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Mondes', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


<ul>

<li>
<?php echo $this->Html->image('site/ico-feu.png', ['alt'=>'Aides culinaires', 'class'=>'icone-utilisateur']); ?>
<span class="cinzel brun">Les aides culinaires</span>
</li>


<?php 

foreach($aides as $k => $article):
echo '<li>';

	if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'Réponse envoyée',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'Réponse',  "alt" => "Réponse", "class" => "notif float-left float-left"]);}
	elseif ($article['statut'] == 3)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'enligne',  "alt" => "En ligne", "class" => "notif float-left float-left"]);}
	
if(!empty($article->illustration)){
echo $this->html->image('illustrations/'.$article->user_id.'/s-'.$article['illustration'], ['class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'AidesCulinaires','action'=>'show', 'prefix'=> false,$article['id']]);

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'AidesCulinaires','action'=>'edit',$article['id']]]);


echo '</li>';

endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'AidesCulinaires', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


<ul>

<li>
<?php echo $this->Html->image("site/ico-remplacer.png", [ "alt" => "Remplacer",  "class" => "icone-utilisateur"]); ?>
<span class="cinzel brun">Par quoi remplacer</span>
</li>


<?php 

foreach($remplacements as $k => $article):
echo '<li>';


	if($article['remplacement']['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['remplacement']['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'Réponse envoyée',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['remplacement']['statut'] == 2)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'Réponse',  "alt" => "Réponse", "class" => "notif float-left float-left"]);}
	elseif ($article['remplacement']['statut'] == 3)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'enligne',  "alt" => "En ligne", "class" => "notif float-left float-left"]);}
	
if(!empty($article->illustration)){
echo $this->html->image('illustrations/produits/'.$article['id'].'/s-'.$article['illustration'], ['class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Remplacements','action'=>'show', 'prefix'=> false,$article['id']]);

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Remplacements','action'=>'edit',$article['id']]]);


echo '</li>';

endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Remplacements', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>

<ul>

<li>
<?php echo $this->Html->image("site/ico-glossaire.png", [ "alt" => "Glossaire",  "class" => "icone-utilisateur"]); ?>
<span class="cinzel brun">Glossaire</span>
</li>


<?php 

foreach($glossaires as $k => $article):
echo '<li>';

	if($article['statut'] == 0)
	{echo $this->Html->image("site/statut-brouillon.png", [ "alt" => "brouillon", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 1)
	{echo $this->Html->image("site/statut-soumis.png", ["title"=>'Réponse envoyée',  "alt" => "Soumis", "class" => "notif float-left"]);}
	elseif ($article['statut'] == 2)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'Réponse',  "alt" => "Réponse", "class" => "notif float-left float-left"]);}
	elseif ($article['statut'] == 3)
	{echo $this->Html->image("site/statut-enligne.png", ["title"=>'enligne',  "alt" => "En ligne", "class" => "notif float-left float-left"]);}
	
if(!empty($article->illustration)){
echo $this->html->image('illustrations/'.$article->user_id.'/s-'.$article['illustration'], ['class'=>'icon']);}
else
{ echo $this->html->image('site/no-image.jpg', ['class'=>'icon']);}

echo $this->html->link($article['name'],['controller'=>'Glossaires','action'=>'show', 'prefix'=> false,$article['id']]);

echo $this->html->Image('site/edit-icon.png',['class'=>'edit-icon margin-dix','url'=>['controller'=>'Glossaires','action'=>'edit',$article['id']]]);


echo '</li>';

endforeach;
?>
<li class="fin-de-liste"><?php echo $this->html->link('Voir tous les articles...', ['controller'=>'Glossaires', 'action'=>'index'], ['class'=>'bert']);?>
</li>



</ul>


</div>
<p class="clear"></p>
</div>


<div class="clear margin-30"> </div>


	          
