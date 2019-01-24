<?php
// inclusion de la librairie TCPDF
    require_once ROOT . DS . 'vendor' . DS . 'mpdf' . DS . 'mpdf' . DS . 'mpdf.php'; 

	mb_internal_encoding('UTF-8');

	if(isset($vertical)){
	
	// Création d'un document TCPDF avec les variables par défaut
   $pdf =new mPDF("","A4","","",10,10,10,10,6,3);

	
	} else {

// Création d'un document TCPDF avec les variables par défaut
   $pdf =new mPDF("","A4-L","","",10,10,10,10,6,3);
   
   }
   
   $pdf->showImageErrors = true;
// voilà l'astuce, on récupère la vue HTML créée par CakePHP pour alimenter notre fichier PDF
    $pdf->writeHTML($this->fetch('content'));


// Sauvegarde sur le disque
if(isset($vertical) && isset($zip)) {

  $pdf->Output($filename . '.pdf', 'F');
  


} else {
  
// Téléchargement direct
    $pdf->Output($filename . '.pdf', 'D');
  
  }
  
?>
