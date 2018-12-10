<STYLE type=text/css>
html {  
  height: 100%;
}

body {  
top:0px;
bottom:0px;
  width: 100%;  
  font-size: 80%;  
  color: black;  

  margin:0;
    padding:0;
     font-family: times, times new roman;
  text-align:justify;
  
  margin-top:10px;
}

/*Reset-------------------------------------------*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}


.tableau-gris { margin-top:30px; 
width:100%;
margin-bottom:30px;
font-size:0.8em;
border:3px solid #bfbfbf;
width: 95%; 
margin-left:auto;
margin-right:auto;
text-align:center;

	}

.tableau-gris tr:nth-child(odd){
	background:rgba(255,255,255,0.9);
}

.tableau-gris tr:nth-child(even){
	background:rgba(209, 209, 209, 0.4);
}

	
.tableau-gris td, .tableau-gris th {
border-left:1px solid #bfbfbf;
border-right:1px solid #bfbfbf;
border-top:1px solid #bfbfbf;
padding : 10px; }

.tableau-gris th {font-family:arial; 
border:1px solid #bfbfbf;
font-size:1em;}

.tableau-gris td:first-child {font-weight:bold;}
    

.center {margin-left:auto; margin-right:auto; text-align:center}

</STYLE>

<img src="../img/headerpdf.png">


<div style="text-align:center; margin-left:auto; margin-right:auto; margin-top:30px">
	<h1 style="font-size:1.3em; margin-left:auto; margin-right:auto">FICHE INDIVIDUELLE D’INSCRIPTION AU PASSAGE DE GRADES</h1>
	
	<table style="margin:10px; border: solid 3px black; width:100%; padding:10px">
		<tr>
			<td class="center" style="font-weight:bold; font-size:1.2em;">PASSAGE DE GRADES</td>
		</tr>
		<tr>
			<td class="center" style="font-weight:bold;font-size:1.éem;">Discipline : <?= $inscription->passage->discipline->name ?></td>
		</tr>
		<tr>
			<td class="center" style="font-weight:bold;font-size:1.2em;">Postulants aux grades de : 1er  à 3ème dan</td>
		</tr>
	</table>
	
	<p class="center" style="font-weight:bold;">DATE : <?= $inscription->passage->date_passage ?></p>
	<p class="center" style="font-weight:bold;">LIEU : <?= $inscription->passage->lieux ?></p>
	
	
	
    <div class="center">
     	<table style="width:80%; border-collapse:collapse; width:100%; margin-top:5px; border:solid 3px black" id="tabInscription">
           
            <tr style="border: solid 3 px black">
                <td style="padding:10px; width:40%">Nom, Prénom</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->nom ?> <?= $inscription->licency->prenom ?> 
            
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Nationalité</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->nationalite ?>
            </tr>
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Adresse</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->adresse ?>
            </tr>
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Téléphone</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->telephone ?>
            </tr>
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Fax</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->fax ?>
            </tr>
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Email</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->email ?>
            </tr>
            <tr style="border-top:solid 3px black">
                <td style="padding:10px; width:40%">Date de naissance</td>                
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->date_naissance ?>
            </tr>
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Lieu de naissance</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->lieu_naissance ?>
            </tr>
            <tr style="border: solid 3 px black">
                <td style="padding:10px; width:40%">Club d'appartenance</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->club->name ?>
            </tr>
            
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Grade précédent</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->grade->name ?>
            </tr>
            <tr>
                <td style="padding:10px; width:40%">Obtenu le</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->grade_actuel_date ?>
            </tr>
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Lieu d'obtention</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->grade_actuel_lieu ?>
            </tr>
            <tr style="border:solid 1px grey;">
                <td style="padding:10px; width:40%">Organisation</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->licency->grade_actuel_organisation ?>
            </tr>
            <tr style="border: solid 3 px black">
                <td style="padding:10px; width:40%">Grade présenté</td>
                <td style="padding:10px; border:solid 1px grey;"><?= $inscription->grade->name ?>
            </tr>            
        </table>
		</div>	
</div>

<p class="center" style="width-100%; margin-bottom:10px; font-weight:bold; margin-top:20px">CONFORMEMENT AU REGLEMENT EN VIGUEUR CNK</p>
<img src="../img/footerpdf.png" style="margin-top:20px;">

        