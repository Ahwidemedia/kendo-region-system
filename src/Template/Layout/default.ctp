
<?php 
    $here = $this->request->here();
    $canonical = $this->Url->build($here, true);
?>

<!doctype html>
<html lang="fr">
<head>

<?php $controller = strtolower($this->name); ?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> <?php echo $title; ?></title>
<meta property="og:title" content="<?php echo $title; ?>" />
<meta property="og:type" content="website" />
<meta property="og:url" content="<?php echo $canonical; ?>" />
<meta property="og:description" content="<?php echo $description; ?>" />
<meta name="description" content="<?php echo $description;?>">
<?php  
echo $this->Html->css('jquery-ui'); 
	echo $this->Html->css('jquery-ui.structure'); 
	
echo $this->fetch('css'); 
	
	echo $this->Html->css('main'); 
	echo $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']); ?>

</head>


<body>
<section>

<h1 class="center padding-3">Interrégions de Kendo 2019 - Fontenay le Comte</h1>

<?php	echo $this->Flash->render();
 echo $this->Flash->render('auth');
     echo $this->fetch('content'); 

?>


</section>


      
    	<?php echo $this->Html->script('jquery-2.2.4.min.js');?>

   	 	<?php echo $this->Html->script('smoothscroll.js');?>
   	 	<?php echo $this->Html->script('jquery.easy-confirm-dialog.min.js');?>
	   	<?php echo $this->Html->script('jquery-ui.js');?>
	   	 
	   	 	 <?php echo $this->Html->script('underscore-min.js');?>
       	<?php echo $this->Html->script('add-element-table.js');?>
       	
 		<?php echo $this->fetch('script'); ?>
  </body>
  
</html>
	    