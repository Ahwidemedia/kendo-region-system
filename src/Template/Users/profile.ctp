
<div class="quatre-vingt center blanc-soixante-dix padding-un-pourcent margin-right-3-pourcent paragraphe-margin">


<h1><?php echo h($user->username) ;?></h1>


<?php
if(!empty($user->avatar)) {
echo $this->Html->image($user->avatar, ['alt'=>'avatar', 'class'=>'vingt-six float-left padding-trois-pourcent']);
	}
	else {  echo $this->Html->image('site/no-avatar.jpg', ['alt'=>'avatar', 'class'=>'vingt-six float-left padding-trois-pourcent']); } ?>

<div class="padding-un-pourcent   float-left">
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
<?php echo $this->Html->image('site/badge-premium.png', ['alt'=>'avatar', 'class'=>$grey_premium.' center soixante']); ?>
</p><p class="<?php echo $grey_premium; ?>center bert">Maître-queue</p>
<p class=" center"><?php echo $num_premium; if($num_premium < '2') { echo ' article';} else { echo ' articles';} ?></p>
<span>Obtenez les 5 autres badges et écrivez au moins 10 articles premium</span>



</div>
</div>

<div class="clear margin-trente"></div>


<div class="moitie-gauche">
<h2 class="margin-trente">Ses dernières recettes</h2>

<?php foreach($row['recettes'] as $k => $article): ?>
	

<div class=" margin-trente padding-un-pourcent quatre-vingt-dix center blanc-soixante-dix border-dix">

 <?php if(!empty($article['illustration'])) { echo $this->Html->image('illustrations/recettes/'.$article['id'].'/m-'.$article['illustration'], [ "alt" => $article['name'],  "class" => "float-left vingt margin-dix margin-right-trente border-dix"]); }
   else {echo $this->Html->image('site/no-image.jpg', ['alt'=> 'Pas d\'icone', 'class' => 'float-left vingt margin-dix margin-right-trente']);}?>

<p class="cinzel " style="margin-top:10px; margin-bottom:5px;"><?php echo $this->Html->link($article['name'],['controller'=>'Recettes','action'=>'show',$article['id'],$article['slug']]) ;?></p>


<div class="profile-recette quatre-vingt" style="margin-left:auto;">
<div class="float-left">
<p><span class=" bert">Catégorie :</span> <?php echo $article['recettecategory']['name'];?></p>
</div>


<div class="float-right  vingt-deux">

<p class="center"><span class="bert">Difficulté:</span></p>
<?php if($article['difficulte'] == '1') {
echo $this->Html->image('site/logo1.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
}elseif($article['difficulte'] == '2') {
echo $this->Html->image('site/logo1.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo1.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
}
elseif($article['difficulte'] == '3'){
echo $this->Html->image('site/logo2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/logo2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
} ?>
</div>

<div class="float-right profile-recette  vingt-trois">
<p class="center"><span class="bert">Coût:</span></p> <?php if($article['cout'] == '1') {
echo $this->Html->image('site/euro1.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
}elseif($article['cout'] == '2') {
echo $this->Html->image('site/euro1.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro1.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
}
elseif($article['cout'] == '3') {
echo $this->Html->image('site/euro2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
echo $this->Html->image('site/euro2.png', ['alt'=>'Illustration', 'class'=>'icon-presentation center']);
} ?>
</div>

<p class="clear-right padding-top-trois-pourcent"> </p>
</div>
<p class="margin-top-trente" style="font-size:0.9em;"><span class="bert">Description : </span><?php echo $this->Text->truncate(h($article['description']), 300, ['ellipsis'=>'...']) ;?>
</p>
 </div>

<?php endforeach;?>
</div>




<div id="publications" class="moitie-droite">
<h2 class="margin-trente">Ses derniers articles</h2>


<?php foreach($row['produits'] as $k => $article): 


echo '<div class="text-left margin-trente padding-un-pourcent quatre-vingt-dix blanc-soixante-dix border-dix">'; ?>
 <?php if(!empty($article['illustration'])) { echo $this->Html->image('illustrations/produits/'.$article['id'].'/m-'.$article['illustration'], [ "alt" => $article['name'],  "class" => "float-left dix  margin-dix margin-right-trente border-dix"]); }
   else {echo $this->Html->image('site/no-image.jpg', ['alt'=> 'Pas d\'icone', 'class' => 'float-left dix margin-dix margin-right-trente']);}?>

  <?php echo $this->Html->link($article['name'],['controller'=>'Produits','action'=>'show',$article['id'],$article['slug']], ['class'=>'cinzel']) ;?>
<p class="margin-dix bert">Catégorie : <?php echo $article['produitcategory']['name'];?></p>


<?php $text = $article['content'];

$text = $this->Text->truncate($text, 300, ['ellipsis'=>'...']); ?>

 <div class="margin-trente"><?php echo $text; ?></div>
   <p class="clear"> </p>
  </div>
	
	<?php endforeach; ?>

<?php foreach($row['encyclopedies'] as $k => $article): 


echo '<div  class="text-left margin-trente padding-un-pourcent quatre-vingt-dix blanc-soixante-dix border-dix">'; ?>
 <?php if(!empty($article['illustration'])) { echo $this->Html->image('illustrations/encyclopedies/'.$article['id'].'/m-'.$article['illustration'], [ "alt" => $article['name'],  "class" => "float-left dix  margin-dix margin-right-trente border-dix"]); }
   else {echo $this->Html->image('site/no-image.jpg', ['alt'=> 'Pas d\'icone', 'class' => 'float-left dix margin-dix margin-right-trente']);}?>

  <?php echo $this->Html->link($article['name'],['controller'=>'Encyclopedies','action'=>'show',$article['id'],$article['slug']], ['class'=>'cinzel']) ;?>
<p class="margin-dix bert">Catégorie : <?php echo $article['encyclopediesouscategory']['name'];?></p>


<?php $text = $article['content'];

$text = $this->Text->truncate($text, 300, ['ellipsis'=>'...']); ?>

 <div class="margin-trente"><?php echo $text; ?></div>
   <p class="clear"> </p>
  </div>
	
	<?php endforeach; ?>
	
	<?php foreach($row['explorations'] as $k => $article): 


echo '<div  class="text-left margin-trente padding-un-pourcent quatre-vingt-dix blanc-soixante-dix border-dix">'; ?>
 <?php if(!empty($article['illustration'])) { echo $this->Html->image('illustrations/explorations/'.$article['id'].'/m-'.$article['illustration'], [ "alt" => $article['name'],  "class" => "float-left dix  margin-dix margin-right-trente border-dix"]); }
   else {echo $this->Html->image('site/no-image.jpg', ['alt'=> 'Pas d\'icone', 'class' => 'float-left dix margin-dix margin-right-trente']);}?>

  <?php echo $this->Html->link($article['name'],['controller'=>'Explorations','action'=>'show',$article['id'],$article['slug']], ['class'=>'cinzel']) ;?>
<p class="margin-dix bert">Catégorie : <?php echo $article['explorationsouscategory']['name'];?></p>


<?php $text = $article['content'];

$text = $this->Text->truncate($text, 300, ['ellipsis'=>'...']); ?>

 <div class="margin-trente"><?php echo $text; ?></div>
   <p class="clear"> </p>
  </div>
	
	<?php endforeach; ?>
	
	



</div>
</div>
<div class="clear margin-30"> </div>


