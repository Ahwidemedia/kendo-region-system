<div class="padding-trois-pourcent"></div>

<h1>Inscription sur Planète Cuisine</h1>
<div class="blanc-soixante-dix soixante-dix center padding-trois-pourcent">
<h2>Un email avec les instructions pour finaliser votre inscription a été envoyé à votre adresse.</h2>
<?php echo $this->Html->image('site/potato.png', [ "alt" => "Mon compte", "id"=>"bienvenue-patate", "class" => "trente float-right"]);?>
<div id="bienvenue" class="float-left padding-trois-pourcent soixante ">
<p class=" margin-dix bert"> Toute l'équipe est heureuse de vous accueillir sur notre planète de passionnés de gastronomie. 
<p class=" margin-dix bert"> Plus qu'une étape avant la création de votre compte...</p>
<p class="margin-trente"> </p>

<p class="margin-dix cinzel">Vous n'avez pas reçu de mail de vérification ? </p>

<p class="margin-dix bert">Vérifiez dans le dossier anti-spam de votre boîte aux lettres ou utiliser le lien suivant pour le renvoyer de nouveau: </p>
<p class="margin-dix center cinzel"><?php echo $this->Html->Link('Renvoyer le mail de vérification',['action' => 'resend']);?></p>

</div>
<p class="clear"> </p>
</div>