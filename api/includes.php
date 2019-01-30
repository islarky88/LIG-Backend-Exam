<?php
function sanitize($toclean) {
	$clean = preg_replace('/[^A-Za-z0-9-_\. ]/','', $toclean);
	return $clean;
}

 ?>
