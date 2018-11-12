<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */


?>


<html>
<body>

<div style="text-align:center; font-family:cambria; margin-left:auto; margin-right:auto; font-size:1.1em; display:block; width:40%; margin-top: 40px;">
<?php echo $this->Html->image('site/logo.png', ['style' => 'display:block; margin-left:auto; margin-right:auto; width:100px;', 'fullBase' => true]); ?>



<p style="font-size:1.3em; color:orange;  font-variant: small-caps;">Bonjour <?php echo $username; ?>,</p>

<p>Merci d'avoir rejoint notre communauté.</p>

<p>Planète Cuisine est une encyclopédie de connaissance autour de la gastronomie et ses produits.
</p>
<p>Nous attendons avec impatience vos contributions et nous espérons que vous trouverez
les informations que vous cherchez sur notre site.</p>

<p style="text-align:center">Pour finaliser votre inscription, veuillez suivre le lien suivant pour vérifier votre e-mail.</p>


<p style="text-align:center; margin-top:20px; background-color:#0066db; border-radius: 6px; padding:15px; font-weight:bold;"><?php echo $this->Html->link("Activer votre compte", ['controller'=>'users', 'action' => 'activate', '_full' => true, $id, $token], ['style'=>'color:white;']);?></p>

</body>
</html>