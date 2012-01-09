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
	//$('a').addcontextmenu('contextmenu2') //apply context menu to links with class="mylinks"
	var as = document.getElementsByTagName("a");

for(var i=0;i<as.length;i++){
    var a = as[i];
    a.oncontextmenu = function(e){ 
        e.preventDefault();
        e.stopPropagation()
        // Delete all menus
        var menus = document.querySelectorAll(".menu");
        if(menus.length > 0){
            for(var i=0;i<menus.length;i++)
                menus[i].parentNode.removeChild(menus[i]);
        }
        var a = e.target;
        var div = document.createElement("div");
        div.className = "menu";
        div.style.position = "absolute";
        div.style.top = a.offsetTop + 12 + "px";
        div.style.left = a.offsetLeft+ "px";
        
        var ul = document.createElement("ul");
         ul.style.color="green";
         ul.style.background= "black";
         
         var href = a.getAttribute("href"); 	
         		 if(href==null){
					   alert("no es posible ralizar Tags con este link");
					   }else{

        for(var i=1;i<=5;i++){
            var li = document.createElement("li");
             li.style.color="white";
            switch(i){
                case 1:
                   var href = a.getAttribute("href"); 
                   /* if(href==null){
					   alert("no es posoble ralizar Tags con este link");
					   }else{*/
                   // li.innerHTML = "<a href='" + "http://es.wikipedia.org" + href + "'>Navegar</a>";
                    li.innerHTML = "<a style= color:white; href='"+ "menuEditado2.php?url="+href+""+ "'>Navegar</a>";
                  // }
                    break;
                case 2:
                    li.innerHTML ="<a style= color:white; href='"+ "http://localhost/RepositorioSemdropsMobile/Semdrops/SymfonySemdropsMobile/web/app_dev.php/semdrops/add_category?val="+href+""+ "'>Agregar Categoria</a>";
                    break;
                case 3:
                    li.innerHTML ="<a style= color:white; href='"+ "http://localhost/RepositorioSemdropsMobile/Semdrops/SymfonySemdropsMobile/web/app_dev.php/semdrops/add_attributeTag?val="+href+""+ "'>Agregar Atributo</a>";
                    break;
                case 4:
                    li.innerHTML ="<a style= color:white; href='"+ "http://localhost/RepositorioSemdropsMobile/Semdrops/SymfonySemdropsMobile/web/app_dev.php/semdrops/add_propertyTag?val="+href+""+ "'>Agregar Property</a>";
                    break;    
                case 5:
                    li.innerHTML = "Cerrar";
                    li.onclick = function(){
                        var parent = this.parentNode.parentNode;
                        parent.parentNode.removeChild(parent);   
                    }
            }
            ul.appendChild(li);
        }
	}
        div.appendChild(ul);
        document.body.appendChild(div);
    };
}
})


jQuery(document).ready(function($){
	//$('img').addcontextmenu('contextmenu2') //apply context menu to all images on the page
		var as = document.getElementsByTagName("img");

for(var i=0;i<as.length;i++){
    var a = as[i];
    a.oncontextmenu = function(e){ 
        e.preventDefault();
        e.stopPropagation()
        // Delete all menus
        var menus = document.querySelectorAll(".menu");
        if(menus.length > 0){
            for(var i=0;i<menus.length;i++)
                menus[i].parentNode.removeChild(menus[i]);
        }
        var a = e.target;
        var div = document.createElement("div");
        div.className = "menu";
        div.style.position = "absolute";
        div.style.top = a.offsetTop + 12 + "px";
        div.style.left = a.offsetLeft+ "px";
        
        var ul = document.createElement("ul");
         ul.style.color="green";
         ul.style.background= "black";
         
         var src = a.getAttribute("src"); 	
         		 if(src==null){
					   alert("no es posible ralizar Tags con esta imagen");
					   }else{

        for(var i=1;i<=5;i++){
            var li = document.createElement("li");
             li.style.color="white";
            switch(i){
                case 1:
                   var src = a.getAttribute("src"); 
                  
                    li.innerHTML = "<a style= color:white; href='"+src+""+ "'>Ver imagen completa</a>";
                    break;
                case 2:
                    li.innerHTML ="<a style= color:white; href='"+ "http://localhost/RepositorioSemdropsMobile/Semdrops/SymfonySemdropsMobile/web/app_dev.php/semdrops/add_category?val="+src+""+ "'>Agregar Categoria</a>";
                    break;
                case 3:
                    li.innerHTML ="<a style= color:white; href='"+ "http://localhost/RepositorioSemdropsMobile/Semdrops/SymfonySemdropsMobile/web/app_dev.php/semdrops/add_attributeTag?val="+src+""+ "'>Agregar Atributo</a>";
                    break;
                case 4:
                    li.innerHTML ="<a style= color:white; href='"+ "http://localhost/RepositorioSemdropsMobile/Semdrops/SymfonySemdropsMobile/web/app_dev.php/semdrops/add_propertyTag?val="+src+""+ "'>Agregar Property</a>";
                    break;    
                case 5:
                    li.innerHTML = "Cerrar";
                    li.onclick = function(){
                        var parent = this.parentNode.parentNode;
                        parent.parentNode.removeChild(parent);   
                    }
            }
            ul.appendChild(li);
        }
	}
        div.appendChild(ul);
        document.body.appendChild(div);
    };
}
})

</script>
</head>
<body>
<?php
include_once ('simple_html_dom2.php');

//$pagina_inicio = file_get_contents('http://es.wikipedia.org/wiki/Wikipedia');

$path='http://es.wikipedia.org/wiki/Wikipedia';
$path2='http://es.wikipedia.org';

//$pagina2=file_get_html('http://es.wikipedia.org/wiki/Wikipedia:Portada');
session_start();
//echo($_SESSION["uri"]);
//$urlCodificada=urlencode('http://es.wikipedia.org/w/index.php?title=Buenos_Aires&useformat=mobile');
//$pagina2=file_get_html($urlCodificada);
if(!($_GET['url']==null)){
	$pagina2=file_get_html($_GET['url']);
	}else{
$pagina2=file_get_html($_SESSION["uri"]);}
if(!$pagina2){echo('EsFalseVacia');}
//echo $pagina2;
foreach($pagina2->find('a') as $element)
     if(  $element-> href[0] == '#'){//amar una funcion para reconer los diferentes links
		 $var=$path.$element->href;
		  $element->href=$var ;
		  }
		else if($element-> href[0] == '/')  
		{
		 $var=$path2.$element->href;	
		 $element->href=$var ;
		}
		else{$element->href=$var;}
foreach($pagina2->find('img') as $element)
{     
		 $var='http:'.$element->src;
		  $element->src=$var ;
		  }
		
//echo'3';
echo $pagina2;
//$ola=strlen($pagina_inicio);
//echo $pagina_inicio;
//echo $ola;
//echo'1';
//procesar($pagina_inicio);
?>


</body>

</html>


