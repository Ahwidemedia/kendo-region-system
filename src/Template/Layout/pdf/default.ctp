<?php
// inclusion de la librairie TCPDF
    require_once ROOT . DS . 'vendor' . DS . 'mpdf' . DS . 'mpdf' . DS . 'mpdf.php'; 
	
	
	
	mb_internal_encoding('UTF-8');


// Création d'un document TCPDF avec les variables par défaut
   $pdf =new mPDF("","A4-L","","",10,10,10,10,6,3);
   $pdf->showImageErrors = true;
// voilà l'astuce, on récupère la vue HTML créée par CakePHP pour alimenter notre fichier PDF
    $pdf->writeHTML($this->fetch('content'));


  
// On indique à TCPDF que le fichier doit être enregistré sur le serveur ($filename étant une variable que vous aurez pris soin de définir dans l'action de votre controller)
    $pdf->Output($filename . '.pdf', 'D');
    
  
?>
