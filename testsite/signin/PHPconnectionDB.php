
<?php
function connect(){
	$conn = oci_connect('xi', 'Navyseal123');
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['connect connect Oracle DB'], ENT_QUOTES), E_USER_ERROR);
	}
    print "Connected to Oracle!"
	return $conn;
}
?>