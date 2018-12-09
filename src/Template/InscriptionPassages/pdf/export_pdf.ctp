<?php echo $this->Html->css('http://ah-widemedia.com/jkcf/css/pdf.css'); ?>
<STYLE type=text/css>
html {  
  height: 100%;
}

body {  
top:0px;
bottom:0px;
  width: 100%;  
  font-size: 90%;  
  color: black;  
 
  margin:0;
    padding:0;
     font-family: cambria, times, times new roman;
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
    



</STYLE>

<h1><?php echo $event['name'];?></h1>
<h2>Passage de grades</h2>
<div class="width-100 center">
    <table class="tableau-gris" id="addelement-table">
    	<thead>
    		<tr style="border:solid 1px #ccc">
    			<th>Discipline</th>
                <th>N° licence</th>
                <th style="min-width:100px">Nom</th>
                <th style="min-width:100px">Prénom</th>
                <th>Sexe</th>
                <th>Grade</th>
                <th>Date de naissance</th>
                <th>Club</th>
                <th>Grade présenté</th>		
    			</tr>
    	</thead>
    
    	<tbody>
    		<?php foreach ($inscriptions as $value) {?>
            	<tr>
            		<td><?= $value->passage->discipline->name ?></td>
            		<td><?= $value->licency->numero_licence ?></td>
            		<td><?= $value->licency->nom ?></td>
            		<td><?= $value->licency->prenom ?></td>
            		<td><?= $value->licency->sexe ?></td>
            		<td><?= $value->licency->grade->name ?></td>
            		<td><?= $value->licency->date_naissance ?></td>
            		<td><?= $value->licency->club->name ?></td>
            		<td><?= $value->grade->name ?></td>
            	</tr>
            <?php } ?> 
    	</tbody>
    </table>

</div>