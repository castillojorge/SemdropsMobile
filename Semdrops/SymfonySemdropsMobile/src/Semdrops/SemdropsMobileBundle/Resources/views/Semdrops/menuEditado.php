<html>
<head>
<link rel="stylesheet" type="text/css" href="jqcontextmenu.css" />

<script type="text/javascript" src="jquery-1.7.min.js"></script>

<script type="text/javascript" src="jqcontextmenu.js">

/***********************************************
* jQuery Context Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script>

<script type="text/javascript">

//Usage: $(elementselector).addcontextmenu('id_of_context_menu_on_page')
//To apply context menu to entire document, use: $(document).addcontextmenu('id_of_context_menu_on_page')

jQuery(document).ready(function($){
	$('a').addcontextmenu('contextmenu2') //apply context menu to links with class="mylinks"
})


jQuery(document).ready(function($){
	$('img').addcontextmenu('contextmenu2') //apply context menu to all images on the page
})

</script>
</head>
<body>
<!--HTML for Context Menu 1-->
<ul id="contextmenu1" class="jqcontextmenu">
<li><a href="#">Item 1a</a></li>
<li><a href="#">Item 2a</a></li>
<li><a href="#">Item Folder 3a</a>
	<ul>
	<li><a href="#">Sub Item 3.1a</a></li>
	<li><a href="#">Sub Item 3.2a</a></li>
	<li><a href="#">Sub Item 3.3a</a></li>
	<li><a href="#">Sub Item 3.4a</a></li>
	</ul>
</li>
<li><a href="#">Item 4a</a></li>
<li><a href="#">Item Folder 5a</a>
	<ul>
	<li><a href="#">Sub Item 5.1a</a></li>
	<li><a href="#">Item Folder 5.2a</a>
		<ul>
		<li><a href="#">Sub Item 5.2.1a</a></li>
		<li><a href="#">Sub Item 5.2.2a</a></li>
		<li><a href="#">Sub Item 5.2.3a</a></li>
		<li><a href="#">Sub Item 5.2.4a</a></li>
		</ul>
	</li>
	</ul>
</li>
<li><a href="#">Item 6a</a></li>
</ul>


<!--HTML for Context Menu 2-->
<ul id="contextmenu2" class="jqcontextmenu">
<li><a href="http://www.ole.com.ar">Navegar 1a</a></li>
<li><a href="#">Item 2a</a></li>
<li><a href="#">Item 1a</a></li>
<li><a href="#">Item 2a</a></li>
</ul>

<?php
include_once ('../simple_html_dom2.php');

//$pagina_inicio = file_get_contents('http://es.wikipedia.org/wiki/Wikipedia');

$path='http://es.wikipedia.org/wiki/Wikipedia';
$path2='http://es.wikipedia.org';

//$pagina2=file_get_html('http://es.wikipedia.org/wiki/Wikipedia:Portada');
echo('HastaACaAnda');
//$urlCodificada=urlencode('http://es.wikipedia.org/w/index.php?title=Buenos_Aires&useformat=mobile');
//$pagina2=file_get_html($urlCodificada);
$pagina2=file_get_html('http://es.wikipedia.org/wiki/Buenos_Aires');
if(!$pagina2){echo('EsFalseVacia');}
echo('HastaACaAnda');
//echo $pagina2;
foreach($pagina2->find('a') as $element)
     if(  $element-> href[0] == '#'){//amar una funcion para reconer los diferentes links
		 $var=$path.$element->href;
		  $element->href="javascript:onClick=alert('$var')" ;
		  }
		else if($element-> href[0] == '/')  
		{
		 $var=$path2.$element->href;	
		 $element->href="javascript:onClick=alert('$var')" ;
		}
		else{$element->href="javascript:onClick=alert('$var')";}
//echo'3';
echo $pagina2;
echo('HastaACaAnda3');
//$ola=strlen($pagina_inicio);
//echo $pagina_inicio;
//echo $ola;
//echo'1';
//procesar($pagina_inicio);
?>


</body>

</html>


