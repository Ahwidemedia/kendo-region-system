<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'error';

?>
<div class="padding-3 width-50 center">
<h2 class="padding-3">Oups, il y a eu une erreur quelque part...</h2>
<?php $this->set('refer', $this->request->referer()); ?>


<p class="padding-3 center"><a href="javascript:history.back()">Retour à la page précédente</a>
</p>

<p class="padding-3 center"><?php echo $this->Html->Link('Retourner à la page d\'accueil',['controller' => 'Pages', 'action' => 'home', 'prefix'=> false]); ?>
</p><?php
if (Configure::read('debug')):
    $this->layout = 'error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?= h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
endif;
?>
<p style="margin-top:30px; color:white; font-size:0.6em">
<?= h($message) ?></p>
<p class="error"  style="margin-top:30px; color:white; font-size:0.6em">
    <strong><?= __d('cake', 'Error') ?>: </strong>
    <?= sprintf(
        __d('cake', 'The requested address %s was not found on this server.'),
        "<strong>'{$url}'</strong>"
    ) ?>
</p>
</div>
<p class="clear"> </p>
</div>


</div>
