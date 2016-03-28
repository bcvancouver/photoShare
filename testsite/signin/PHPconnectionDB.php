<?php
function connect(){
	$conn = oci_connect('xi', 'Navyseal123');
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['fail to connect Oracle DB'], ENT_QUOTES), E_USER_ERROR);
	}
	return $conn;
}
?>