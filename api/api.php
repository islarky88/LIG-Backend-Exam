<?php
require_once('includes.php');
$debug = 0;
$response = '';
$rawreponse = '';

function testRequest() {

    echo $_GET['key1'].'-'.$_GET['key2'].'-'.$_GET['key3'].'-'.$_GET['key4'];
    echo '<br/><br/>';
    echo $_SERVER['REQUEST_METHOD'];

}

if (isset($_GET['key1'])) {
  $key1 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['key1']));
}
if (isset($_GET['key2'])) {
  $key2 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['key2']));
}
if (isset($_GET['key3'])) {
  $key3 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['key3']));
}
if (isset($_GET['key4'])) {
  $key4 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['key4']));
}




  $method = $_SERVER['REQUEST_METHOD'];

// START OF CHECK OF REQUEST METHOD TO IDENTIFY API TYPE

  if ($method === 'POST') {

    if ($key1 == 'login') {

      $response['token'] = md5('test');
      $response['username'] = 'user';
      $response['password'] = 'pass';

      print_r($_REQUEST);

    $rawreponse = array (
        'message' => 'The given data was invalid.',
        'errors' =>
        array (
          'email' =>
          array (
            0 => 'The email field is required.',
          ),
          'password' =>
          array (
            0 => 'The password field is required.',
          ),
        ),
      );





    }




  } else if ($method === 'GET') {

    if ($key1 == 'posts') {


      $rawreponse = array (
      'data' =>
      array (
        0 =>
        array (
          'id' => 1,
          'user_id' => 1,
          'title' => 'new title',
          'slug' => 'new-title',
          'content' => 'content of the post',
          'created_at' => '2019-01-23 02:06:06',
          'updated_at' => '2019-01-23 02:13:26',
          'deleted_at' => NULL,
        ),
      ),
      'links' =>
      array (
        'first' => 'http://127.0.0.1:8000/api/posts?page=1',
        'last' => 'http://127.0.0.1:8000/api/posts?page=1',
        'prev' => NULL,
        'next' => NULL,
      ),
      'meta' =>
      array (
        'current_page' => 1,
        'from' => 1,
        'last_page' => 1,
        'path' => 'http://127.0.0.1:8000/api/posts',
        'per_page' => 15,
        'to' => 1,
        'total' => 1,
      ),
    );

     $response = json_encode($rawreponse);


   } //end of if posts

//print_r($_REQUEST);



  } else if ($method === 'PUT') {

  } else if ($method === 'DELETE') {

  }

  // Output JSON response
  if ($response != '') {
    echo $response;
  } else {
    print_r($_REQUEST);
  }



 ?>
