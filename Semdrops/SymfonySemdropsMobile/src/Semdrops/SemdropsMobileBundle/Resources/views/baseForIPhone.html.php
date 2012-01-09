<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php $view['slots']->output('title', 'Semdrops Mobile') ?></title>
	<link href="<?php echo $view['assets']->getUrl('bundles/semdropssemdropsmobile/style/iPhone.css') ?>" rel="stylesheet" type="text/css" />


</head>
<body>
<div id= "header"><h1><?php $view['slots']->output('_header') ?></h1></div>
	<div id= "content"><?php $view['slots']->output('_content') ?> </div>
	
</body>
</html>
