 tinymce.init({
selector: "textarea",

invalid_styles:'color font-size',
entity_encoding : "raw",
selector : "textarea:not(.mceNoEditor)",
theme: "advanced",
theme_advanced_blockformats : "Titre=h2,Soustitre=h3,Paragraphe=p",
valid_elements:'h2,h3,p,strong,em,li,ul,table[class],td,tr,th, a[href|target=_blank]',
extended_valid_elements : 'img[class|src|alt|title|style],span[style]',
valid_styles: {
 'span': 'text-decoration',
 'img': 'width,height'},
plugins:'inlinepopups,image,paste,spellchecker,autosave',
spellchecker_language: 'fr_FR',
paste_auto_cleanup_on_paste : true,
paste_remove_styles: true,
paste_remove_styles_if_webkit: true,
paste_strip_class_attributes: true,
theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,image,|,formatselect,|,spellchecker,code',
paste_remove_spans : true,
paste_remove_styles: true,
image_explorer : 'https://www.planete-cuisine.com/medias/index/5',
relative_urls : false,
image_edit : 'https://www.planete-cuisine.com/medias/show',
content_css : 'https://www.planete-cuisine.com/css/wysiwyg.css',
 });
 
 function send_to_editor(content)
 {
 var ed = tinymce.activeEditor;
 ed.execCommand('mceInsertContent',false,content);
 
 }
