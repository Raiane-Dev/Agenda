<?php

include('config.php'); 
Site::updateUsuarioOnline(); 
Site::contador(); 

$homeController = new controller\homeController();


Router::get('/',function() use ($homeController){
	$homeController->index();
});

?>
