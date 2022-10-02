<?php
if (extension_loaded('sockets')) {
	//Create socket IPv4
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) ;
	echo "sock"
}
else{
	echo "no sock";
}
?>