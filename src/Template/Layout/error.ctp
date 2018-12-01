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
    <title>
        <?php echo $title; ?>
    </title>
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

    <header>

        <div class="header-right">
            <?php if ($conn = $this->request->session()->read('Auth.User')){ 
    

  echo $conn['nom'].' - '.$conn['prenom'].' - '.$conn['club']['nom'];
    
    
    
 }
 
 else {
 

echo $this->Html->link(
    'Connexion',
    ['controller' => 'Users', 'action' => 'login']
 );
 
 }
    ?>

        </div>
    </header>

  <section>

    
     <?php 
     	echo $this->Flash->render();
 echo $this->Flash->render('auth');
     echo $this->fetch('content'); 
    	?>


          
     </section>

    <footer>
        <div class="center">
            <?php echo $this->html->image('logo-footer.png', ['url'=>['controller'=>'Pages','action'=>'index','prefix'=>false],'class'=>'center logo-foot']);?>
            <p class="center">
                <?php echo $this->html->link('Connexion', ['controller'=>'Users', 'action'=>'login']); ?>
            </p>

            <p class="float-left">
                <?php echo $this->html->link('Mentions légales', ['controller'=>'Pages', 'action'=>'mentions']); ?>
            </p>

            <p class="float-right">
                <?php echo $this->html->link('Contact', ['controller'=>'Pages', 'action'=>'contact']); ?>
            </p>
        </div>

    </footer>


    <?php echo $this->Html->script('jquery-2.2.4.min.js');?>


    <?php echo $this->Html->script('jquery.easy-confirm-dialog.min.js');?>
    <?php echo $this->Html->script('jquery-ui.js');?>

    <?php echo $this->Html->script('underscore-min.js');?>
    <?php echo $this->Html->script('add-element-table.js');?>

    <?php echo $this->fetch('script'); ?>
</body>

</html>

