<?php $view->extend('SemdropsSemdropsMobileBundle::baseForIPhone.html.php') ?>
<?php $view['slots']->set('_header', 'Hello World Application') ?>
<div align="right" >
<a href= "<?php echo $view['router']->generate('logout') ?>">cerrar sesion</a>
</div>
<h2>Interactue con los links e imagenes</h2>
<div align="center">
<input type= "button" onclick= location.href="<?php echo $view['router']->generate('tagForm') ?>" value="Ingrese Una Uri Nueva" name="gobackButton" class= "resetButtonStyle white button" />
</div>

<input type= "button" onclick= location.href="<?php echo $view['router']->generate('homepage') ?>" value="Back to Main Menu" name="gobackButton" class= "resetButtonStyle white button" />

<object width="100%" height="100%" type="text/html" data="http://localhost/RepositorioSemdropsMobile/Semdrops/SymfonySemdropsMobile/web/menu/menuEditado2" > 
