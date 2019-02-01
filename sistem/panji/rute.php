<?php 
libxml_use_internal_errors(true);

// include fungsi
include "fungsi.php"; 


function utama($template_dir,$rute_dir ){
		
$rutes		= list_rute($template_dir,$rute_dir);
$rute		= "<h1> Not found !! </h1>";
if(isset($_SERVER['REQUEST_URI'])){
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

}else{
$path ="/";	
	
}

	foreach($rutes as $rts){
		
		if(($rts[0] == $path) and ( !empty($rts[1]) )){
			
			$call	= explode(":",($rts[1]));
			
			if( !isset($call[1]) ){ 
			
			$rute	= file_get_contents($template_dir.$call[0]);
			

			$document = new DOMDocument();
			$document -> loadHTML($rute);
			
			while($document->getElementsByTagName("omnji")->length > 0){ 
				foreach($document->getElementsByTagName("omnji") as $omnji){
					$omnji->parentNode->nodeValue ="";
					
				} 
			}
			
			
			$rute=$document->saveHTML();
			
			}
			
			else{
			
			
			$omnjis = array();
			$omnji_file	= file_get_contents($rute_dir."omnji/".$call[0].".xml");
			
			$omnji = new DOMDocument();
			$omnji -> loadXML($omnji_file);
			

			$rute = file_get_contents($template_dir.$omnji->getElementsByTagName("listomnji")->item(0)->getAttribute("tema"));
			foreach($omnji->getElementsByTagName("omnji") as $omnjii){
			
			$out = preg_replace('#<omnji (.*?)>|</omnji>#is', '', $omnji->saveXML($omnjii));
			
			$omnjis[$omnjii->getAttribute("isi")]= $out;
			} 
		
 			$document = new DOMDocument();
			$document -> loadHTML($rute);
			

			while($document->getElementsByTagName("omnji")->length > 0){ 

				foreach($document->getElementsByTagName("omnji") as $omnjii){

					$omnjii->parentNode->nodeValue = $omnjis[$omnjii->getAttribute("isi")];

				} 

			}
			
			$rute=htmlspecialchars_decode($document->saveHTML());
 			

					
			}
		}
		
	}

file_put_contents("../sistem/panji/temp/out.php",trim($rute));
include "../sistem/panji/temp/out.php";

}

?>

