<?php
function sanitize($toclean) {
	$clean = preg_replace('/[^A-Za-z0-9-_\.@ ]/','', $toclean);
	return $clean;
}

function cleanurl($toclean) {
  $clean = str_replace('_', ' ', $toclean);
  $clean = str_replace('-', ' ', $clean);
  $clean = rawurlencode($clean);
  $clean = str_ireplace("%c2%b2", "2", $clean);
  $clean = str_ireplace("%c2%b3", "3", $clean);
  $clean = rawurldecode($clean);
  setlocale(LC_ALL, 'en_GB');
  $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $clean);
  $clean = strtolower(preg_replace('/[^\w]+/u', ' ', $clean));
  $clean = trim($clean);
  $clean = str_replace(' ', '-', $clean);
  $clean = str_replace('--', '-', $clean);
  return $clean;
}

function testRequest() {
  echo $_GET['key1'].'-'.$_GET['key2'].'-'.$_GET['key3'].'-'.$_GET['key4'];
  echo '<br/><br/>';
  echo $_SERVER['REQUEST_METHOD'];
}

?>
