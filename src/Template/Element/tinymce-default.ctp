


<?php echo $this->Html->scriptStart(['block' => true]);?>

 tinymce.init({
selector: "textarea",
invalid_styles:'color font-size',
entity_encoding : "raw",
selector : "textarea:not(.mceNoEditor)",
theme: "advanced",
theme_advanced_blockformats : "Titre=h2,Soustitre=h3,Paragraphe=p",
valid_elements:'h2,h3,p,strong,em,li,ul,table[class],td,tr,th,a[href]',
extended_valid_elements : 'img[class|src|alt|title|style],span[style],td[style|colspan|class],th[style|class|colspan]',
valid_styles: {
 'span': 'text-decoration',
 'img': 'width,height'},
plugins:'inlinepopups,image,paste,spellchecker,autosave',
spellchecker_language: 'fr_FR',
paste_auto_cleanup_on_paste : true,
paste_remove_styles: true,
paste_remove_styles_if_webkit: true,
paste_strip_class_attributes: true,
autosave_interval: "20s",
autosave_retention: "30m",
autosave_prefix: "tinymce-autosave-{<?php echo $this->Url->build('/tiny'); ?>}{<?php echo $this->Url->build(['controller' =>'medias', 'action' => 'show']); ?>}-{<?php echo $article['id'];?>}-",
theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,image,|,formatselect,|,spellchecker,code,|,restoredraft',
paste_remove_spans : true,
paste_remove_styles: true,

image_explorer : '<?php echo $this->Url->build(['controller' =>'medias', 'action' => 'index', $article['id']]);?>',
relative_urls : false,
image_edit : '<?php echo $this->Url->build(['controller' =>'medias', 'action' => 'show']); ?>',
content_css : '<?php echo $this->Url->build('/css/wysiwyg.css'); ?>',
 });
 
 

 
 function send_to_editor(content)
 {
 var ed = tinymce.activeEditor;
 ed.execCommand('mceInsertContent',false,content);
 
 }
<?php $this->Html->scriptEnd(); ?>

<?php echo $this->Html->scriptStart(['block' => true]);?>

$( "h2" ).prev( "p" ).addClass( "dernier");
<?php $this->Html->scriptEnd(); ?>