<?php
require_once('includes.php');
$debug = 0;

$mysqltime = date ("Y-m-d H:i:s");

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

        $rawResponse = array (
          'token' => md5($email.$password),
          'token_type' => 'bearer',
          'expires_at' => $date,
        );

        $response = json_encode($rawResponse);


      } else { //If user/pass combination is wrong


        $rawResponse = array (
            'message' => 'The given data was invalid.',
            'errors' => array()
            );

          //print_r($rawResponse);


          $emailerror = array('email' =>
          array (
            0 => 'The email field is required.',
          ));

          $passworderror = array('email' =>
          array (
            0 => 'The email field is required.',
          ));

              array_push($rawResponse['errors'], $emailerror);

              print_r($rawResponse);



                $response = json_encode($rawResponse);




      } //end of login check





    } //end of key1 login




  } else if ($method === 'GET') {

    //echo $_GET['page'];

    if ($key1 == 'posts') {

      if (isset($_GET['page']) && $_GET['page'] > 0) {
        $currentPage = intval($_GET['page']);
      }


      // fetched data from database
      $pid = 1;
      $uid = 1;
      $title = 'Title Holder -Page ' . $currentPage;
      $urlslug = '';
      $content = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
      $created = '2019-01-23 02:06:06';
      $updated = $mysqltime;
      
      //preparing raw response
      $rawResponse = array (
      'data' =>
      array (
        0 =>
        array (
          'id' => $pid,
          'user_id' => $uid,
          'title' => $title,
          'slug' => $urlslug,
          'content' => $content,
          'created_at' => $created,
          'updated_at' => $updated,
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

     $response = json_encode($rawResponse);


   } //end of if posts

//print_r($_REQUEST);



  } else if ($method === 'PUT') {

  } else if ($method === 'DELETE') {

  }


    echo $response;




 ?>
