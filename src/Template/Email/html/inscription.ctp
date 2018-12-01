<html>
<body>

<div style="text-align:center; font-family:cambria; margin-left:auto; margin-right:auto; font-size:1.1em; display:block; width:40%; margin-top: 40px;">
<?php echo $this->Html->image('logo.png', ['style' => 'display:block; margin-left:auto; margin-right:auto; width:100px;', 'fullBase' => true]); ?>



<p style="font-size:1.3em; color:orange;  font-variant: small-caps;">Bonjour <?php echo $username; ?>,</p>

<p>Merci de vous être inscrit.</p>

<p style="text-align:center">Pour finaliser votre inscription, veuillez suivre le lien suivant pour vérifier votre e-mail.</p>


<p style="text-align:center; margin-top:20px; background-color:#0066db; border-radius: 6px; padding:15px; font-weight:bold;"><?php echo $this->Html->link("Activer votre compte", ['controller'=>'users', 'action' => 'activate', '_full' => true, $id, $token], ['style'=>'color:white;']);?></p>

</body>
</html>