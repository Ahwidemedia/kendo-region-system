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

article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {

}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}

/*------Principal------*/
/*Reset-------------------------------------------*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}

article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
}

/*----- Fond de page----*/

html {  
  height: 100%;
}

body {  
height:100%;
top:0px;
bottom:0px;
  width: 100%;  
  font-size: 1em;  
  color: black;  
  background-attachment: fixed;  
  background-size: cover;  
 margin:0;
    padding:0;
    font-family: arial, helvetica;
}


/*Mise en page principale-------------------------------------------*/


section {  
  width: 100%;
}



h1 {font-family:arial; 
text-align:center;
font-size:2em;}

h2 {  ont-family:arial; 
text-align:center;
font-size:1.5em;
margin:3% auto;
 }

h3 {  
  
}

tr td {  
  top: 0px;  
  vertical-align: middle;

}


p, ul, td {  
font-size:1em;
  font-family: arial,cambria, times, 'times new roman';
  color: #999;
}


li {font-family: cambria, times, 'times new roman';
  color: black;}

strong, .strong {font-weight:bold}
em {font-style:italic;}

p {  
  text-align:justify;
  line-height:1.2em;
}



.height-100-vh {height:100vh;overflow-y: hidden; }

.vertical { margin-top: 50vh; /* poussé de la moitié de hauteur de viewport */
  transform: translateY(-50%);}

.border-grey {border: solid 1px grey;}

.padding-50 {padding:50px;}

.bold {font-weight: bold ;}
.italic {font-style: italic;}

.float-none {float:none;}

.digital {font-family:digital;}

/*Mode Gris*/

.grey {filter: grayscale(1);
  -webkit-filter: grayscale(1);
  -moz-filter: grayscale(1);
  -o-filter: grayscale(1);
  -ms-filter: grayscale(1);

}


.hover-grey {transition:all 0.3s ease-in;
-webkit-transition: all 0.3s ease-in;
-moz-transition: all 0.3s ease-in;}
.hover-grey:hover {
filter: grayscale(1);
  -webkit-filter: grayscale(1);
  -moz-filter: grayscale(1);
  -o-filter: grayscale(1);
  -ms-filter: grayscale(1);
}


.mode-lien {border:solid 1px grey; padding:3%}

.red {color:#c70000}
.green {color:green}
.black {color:black}
.white {color:white;}
.text-gris {color:#999}

.background-red {background-color:#c70000}
.background-red a:link, .background-red a:visited, .background-red a:hover {color:white}
.background-red:hover {background-color: #a80000;}


.arial {font-family: 'arial'}
.arial {font-family:'arial';}


.text-left{text-align:left;}
.text-center{text-align:center;}
.text-right{text-align:right;}


.line-2 {line-height:1.5em;}
.lineup {line-height:2em}
.line-height-40-px {line-height:40px;}
.height-40-px {height:40px;}
.height-2 {height:2em;}
.line-height-2 {line-height:2em;}
.line-40 {line-height:40px}
.line-40 a{line-height:40px}
.height-40 {height:40px}



.font-demi {font-size:0.5em}
.font-1 {font-size:1.2em;}
.font-2 {font-size:1.5em;}
.font-3 {font-size:2em;}



.opacity {opacity:0.5; filter: alpha(opacity=50);}

.transparent {
    opacity: 0.1;
    filter: alpha(opacity=10);
}


.right {width:100%; text-align:right; display:block; clear:both;}


.hidden {overflow:hidden}
.block {display:block;}

.border-dix {border-radius:10px}

.width-5 {width:5%;}
.width-10 {width:10%;}
.width-15 {width:15%;}
.width-20 {width:20%;}
.width-23 {width:23%;}
.width-25 {width:25%;}
.width-28 {width:29%;}
.width-30 {width:30%;}
.width-40 {width:40%;}
.width-45 {width:45%;}
.width-50 {width:50%}
.width-60 {width:60%;}
.width-70 {width:70%;}
.width-80 {width:80%;}
.width-90 {width:90%;}
.width-100 {width:100%;}



.padding-1 {padding:1%}
.padding-2 {padding:2%}
.padding-3 {padding:3%}
.padding-5 {padding:5%}


.margin-1 {margin:1%}
.margin-3 {margin:3%}

.margin-top-1 {margin-top:1%;}
.margin-top-3 {margin-top:3%;}

.margin-10-px {margin:10px;}

.margin-top-10-px {margin-top:10px;}
.margin-top-30-px {margin-top:30px;}
.margin-top-50-px {margin-top:50px;}

.margin-left-10-px {margin-left:10px;}
.margin-left-30-px {margin-left:30px;}

.margin-left-1-pourcent {margin-left:1%;}
.margin-right-1-pourcent {margin-right:1%;}



.margin-right-10-px {margin-right:10px;}
.margin-right-30-px {margin-right:30px;}

.margin-bottom-1 {margin-bottom:1%;}


.margin-bottom-10-px {margin-bottom:10px;}
.margin-bottom-30-px {margin-bottom:30px;}
.margin-top-bottom {margin-top:0.5%; margin-bottom:0.5%}



.min-height-200 {min-height:200px;}
.min-height-300 {min-height:300px;}
.min-height-500 {min-height:500px;}
.min-height-1000 {min-height:1000px;}

.max-height-100{max-height:100px;}

.height-100 {height:100px}
.height-300 {height:300px;}



.inline-block {display:inline-block;}
.relative {position:relative;}
.absolute {position:absolute;}

.container-flex {
 display:flex;
 flex-wrap: wrap;
 justify-content: space-around;}

.onnevoitpas{display:none;}



.float-right {float:right}
.float-left {float:left}


.table {display:table; vertical-align:middle;}
.table-cell {display:table-cell; vertical-align:middle;}


   .center {text-align:center; margin-left:auto; margin-right:auto;}
   .moitie-gauche {float:left; width:50%; margin:0;padding:0; display:table;}
   .moitie-droite {float:right; width:50%; margin:0;padding:0; display:table;}

.bloc-3 {width:33%; margin:0; padding:0;}


.clear {clear:both;}


.border-black {border:solid black 1px}

.flou {
   color: transparent;
   text-shadow: 0 0 5px rgba(0,0,0,0.5);
}

.icon-add {height:25px; width:25px;}

.top-right {top:15px; right:15px;}

.select {display:table;margin-left:auto; margin-right:auto; padding:1%;}

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

	<h2>Commissaires et arbitres</h2>
	
	
<table class="tableau-gris">
	<thead>
		<tr><th></th>
			<th>Nom</th>
			<th>Prénom</th>
			<th>Niveau Arbitre</th>
            <th>Niveau Commissaire</th>
            <th>Samedi</th>
            <th>Dimanche</th>
			<th>Club</th>
		
			</tr>
	</thead>

	<tbody>
		<?php foreach($articles as $article){
		
		?>

	<tr>
		<td></td>
		
		<td>
			<?php echo $article['licency']['nom'];  ?>
		</td>

		<td>
			<?php echo $article['licency']['prenom'];  ?>
		</td>
		<td>
			<?php if($article['licency']['arbitre'] == 1){
			 echo 'Bénévole';
			}elseif($article['licency']['arbitre'] == 2){
            echo 'Diplômé régional';
        }
                elseif($article['licency']['arbitre'] == 3){
                    echo 'Diplômé national';
                }
		   ?>
		</td>
        <td>
        <?php if($article['licency']['commissaire'] == 1){
			 echo 'Bénévole';
			}elseif($article['licency']['commissaire'] == 2){
            echo 'Diplômé régional';
        }
                elseif($article['licency']['commissaire'] == 3){
                    echo 'Diplômé national';
                }
		   ?>
        </td>
        <td><?php if (strpos($article['presence'], '1') !== false) {
    echo 'X';
} ?></td>
         <td><?php if (strpos($article['presence'], '2') !== false) {
    echo 'X';
} ?></td>
        
        
        <td>	<?php 
			 echo $article['licency']['club']['name'];
			
		   ?>
        
        </td>

	

	</tr>

	<?php	}
		 ?>

	</tbody>
	</table>
	