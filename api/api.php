<?php
require_once('includes.php');
$debug = 0;
$response = '';
$rawresponse = '';

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

      print_r($_REQUEST);

      //  $user = $_REQUEST
    //    $response['username'] = 'user';
      //  $response['password'] = 'pass';

      if (isset($_POST['email'])) {
        $email = santize($_POST['email']);
      } else {
        $email = '';
      }

      if (isset($_POST['password'])) {
        $password = sanitize($_POST['password']);
      } else {
        $password = '';
      }

      //Check if Authenticated User
      if ($email == 'bertrand_kintanar@ligph.com' && $password == 'password') {

        $date = strtotime("+7 day");
        $date = date('Y-m-d H:i:s', $date);

        $rawresponse = array (
          'token' => md5($email.$password),
          'token_type' => 'bearer',
          'expires_at' => $date,
        );

        $response = json_encode($rawresponse);


      } else { //If user/pass combination is wrong


        $rawresponse = array (
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
          print_r($rawresponse);


              $emailerror = array('email' =>
              array (
                0 => 'The email field is required.',
              ));

              array_push($tempArray, $emailerror);




                $response = json_encode($rawresponse);




      } //end of login check





    } //end of key1 login




  } else if ($method === 'GET') {

    if ($key1 == 'posts') {

      $rawresponse = array (
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

     $response = json_encode($rawresponse);


   } //end of if posts

//print_r($_REQUEST);



  } else if ($method === 'PUT') {

  } else if ($method === 'DELETE') {

  }


    echo $response;




 ?>
