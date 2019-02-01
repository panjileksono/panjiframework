<?php
function list_rute($template_dir,$rute_dir){

	$rutes=array();
	$indexs=0;
	foreach(scandir($rute_dir) as $route){
		if(filetype($rute_dir.$route) == "file"){
		
		$full_route = file_get_contents($rute_dir.$route);
		
	$routes = new domdocument() ;	
	$routes->loadxml($full_route);
	

	foreach($routes->getElementsByTagName("rute") as $rts){
		
		$rutes[$indexs++] = array(
			$rts->getElementsByTagName("path")->item(0)->nodeValue,
			$rts->getElementsByTagName("call")->item(0)->nodeValue
		);

	}
		}
	}


	return $rutes;
	
}
?>