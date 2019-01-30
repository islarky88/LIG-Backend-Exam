<?php
require_once('includes.php');
$debug = 0;


function testRequest() {

    echo $_GET['key1'].'-'.$_GET['key2'].'-'.$_GET['key3'].'-'.$_GET['key4'];
    echo '<br/><br/>';
    echo $_SERVER['REQUEST_METHOD'];

}
if (isset($_GET['$key1'])) {
  $key1 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['$key1']));
}
if (isset($_GET['$key2'])) {
  $key2 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['$key2']));
}
if (isset($_GET['$key3'])) {
  $key3 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['$key3']));
}
if (isset($_GET['$key4'])) {
  $key4 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['$key4']));
}


if (isset($_SERVER['REQUEST_METHOD'])) {

  $method = $_SERVER['REQUEST_METHOD'];


  if ($method === 'POST') {

    if ($key1 == 'login') {

      $response['token'] = md5('test');
      $response['username'] = 'user';
      $response['password'] = 'pass';


    }

  } else if ($method === 'GET') {



print_r($_REQUEST);



  } else if ($method === 'PUT') {

  } else if ($method === 'DELETE') {

  }


}

 ?>
