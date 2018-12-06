<html>
<body>

<div style="text-align:center; font-family:cambria; margin-left:auto; margin-right:auto; font-size:1.1em; display:block; width:40%; margin-top: 40px;">
<?php echo $this->Html->image('logo.png', ['style' => 'display:block; margin-left:auto; margin-right:auto; width:100px;', 'fullBase' => true]); ?>

<p style="font-size:1.3em; color:orange;  font-variant: small-caps;">Bonjour <?php echo $username; ?>,</p>

<p>Vous recevez cet e-mail car une demande de nouveau mot de passe a été faite pour votre e-mail.</p>

<p style="text-align:center; color:white !important; margin-top:20px; border:solid red 1px; border-radius: 6px; padding:10px; font-weight:bold;"><?php echo $this->Html->link("Lien", ['controller'=>'Users', 'action' => 'password', '_full' => true, $id, $token]);?></p>

<p>Si vous n'avez pas demandé de mot de passe, merci d'ignorer ce message.</p>

</body>
</html>

