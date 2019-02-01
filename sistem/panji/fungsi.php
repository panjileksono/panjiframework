<?php 


foreach(scandir("../sistem/panji/fungsi/",1) as $incld){
	if(filetype("../sistem/panji/fungsi/".$incld)=="file"){
		
		include  "../sistem/panji/fungsi/".$incld;
		
	}
	
}



?>