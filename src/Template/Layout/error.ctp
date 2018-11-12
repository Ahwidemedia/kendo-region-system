
<!doctype html>
<htm lang="fr">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Oups, il y a eu une erreur...</title>
<meta name="description" content="Il y a eu une erreur quelque part..."/>
<meta name="copyright" content="planete-cuisine, Copyright (c) 2016"/>


<?php 	
	echo $this->html->css('print', ['media' => 'print']);
	echo $this->html->css('main'); 
	echo $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']); ?>
<?php echo $this->fetch('css'); ?>


</head>
<body>
  <section>
<h1 class="center padding-3">Interrégions de Kendo 2019 - Fontenay le Comte</h1>

    
     <?php 
     	echo $this->Flash->render();
 echo $this->Flash->render('auth');
     echo $this->fetch('content'); 
    	?>


          
    </section>
    
    </div>
    
   
      
    	<?php echo $this->Html->script('jquery-2.2.4.min.js');?>

   	 <?php echo $this->Html->script('smoothscroll.js');?>
 		<?php echo $this->fetch('script'); ?>

	  </body>
  
</html>

