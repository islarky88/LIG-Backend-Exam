<?php
require_once('includes.php');
$debug = 0;
$response = '';
$rawResponse = '';
$mysqltime = date ("Y-m-d H:i:s");

function testRequest() {

    echo $_GET['key1'].'-'.$_GET['key2'].'-'.$_GET['key3'].'-'.$_GET['key4'];
    echo '<br/><br/>';
    echo $_SERVER['REQUEST_METHOD'];

}

if (isset($_GET['key1'])) {
  $key1 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['key1']));
} else {
  $key1 = '';
}
if (isset($_GET['key2'])) {
  $key2 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['key2']));
} else {
  $key2 = '';
}
if (isset($_GET['key3'])) {
  $key3 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['key3']));
} else {
  $key3 = '';
}
if (isset($_GET['key4'])) {
  $key4 = trim(preg_replace('/[^A-Za-z0-9-]/','',$_GET['key4']));
} else {
  $key4 = '';
}




  $method = $_SERVER['REQUEST_METHOD'];

// START OF CHECK OF REQUEST METHOD TO IDENTIFY API TYPE

  if ($method === 'POST') {



    if ($key1 == 'login') {
      // http://dev.cody.asia/api/login

      $json = file_get_contents('php://input');
      $obj = json_decode($json, true);


      // Get form params and sanitize
      if (isset($obj['email'])) { $email = sanitize($obj['email']); } else { $email = ''; }
      if (isset($obj['password'])) { $password = sanitize($obj['password']); } else { $password = ''; }


      // Check if Authenticated User
      if ($email == 'bertrand_kintanar@ligph.com' && $password == 'password') {

        $date = strtotime("+7 day");
        $date = date('Y-m-d H:i:s', $date);

        $rawResponse = array (
          'token' => md5($email.$password),
          'token_type' => 'bearer',
          'expires_at' => $date,
        );


        $response = json_encode($rawResponse);


      } else { // If user/pass combination is wrong


        $rawResponse = array (
            'message' => 'The given data was invalid.'
            );

          // print_r($rawResponse);
/*
          if ($email == '') {
            array_push($rawResponse['errors'], array('email' =>
            array (
              0 => 'The email field is required.',
            )));

          }

          if ($password == '') {
            array_push($rawResponse['errors'], array('password' =>
            array (
              0 => 'The password field is required.',
            )));

          }
          */


          $response = json_encode($rawResponse);




      } //end of login check


    } //end of key1 login

    if ($key1 == 'logout') {

      $rawResponse = array (
        'logout' => 'success',
      );

      $response = json_encode($rawResponse);

      //CLEAR COOKIE, TOKEN, AUTHENTICATION, ETC CODE
      //logout();

    }

    if ($key1 == 'register') {

      // Get form params and sanitize

      $json = file_get_contents('php://input');
      $obj = json_decode($json, true);

      if (isset($obj['name'])) { $name = sanitize($obj['name']); } else { $name = ''; }
      if (isset($obj['email'])) { $email = sanitize($obj['email']); } else { $email = ''; }
      if (isset($obj['password'])) { $password = sanitize($obj['password']); } else { $password = ''; }
      if (isset($obj['password_confirmation'])) { $passwordConfirmation = sanitize($obj['password_confirmation']); } else { $passwordConfirmation = ''; }


      // Check if all detaills are complete to register
      if ($name != ''
        && $email != ''
        && $password != ''
        && $password == $passwordConfirmation) {

          // should check detabase for ID autoIncrement of new registrations
          $userID = 1;

        $rawResponse =   array (
            "name" => $name,
            "email" => $email,
            "updated_at" => $mysqltime,
            "created_at" => $mysqltime,
            "id" => $userID
        );
        $response = json_encode($rawResponse);


      } else { //Registration errors


        $rawResponse = array (
          'message' => 'There is an error with your Registration'
        );



          array_push($rawResponse, array('email' =>
          array (
            0 => 'The email has already been taken.',
          )));

          $response = json_encode($rawResponse);



      } // End of registration





    //  http_response_code(201);

      //CLEAR COOKIE, TOKEN, AUTHENTICATION, ETC CODE
      //logout();

    } //end of key1 login




  } else if ($method === 'GET') {

    //echo $_GET['page'];

    if ($key1 == 'posts') {

      if ($key2 == 'new-titles') {
        //http://dev.cody.asia/api/posts/new-titles

        $rawResponse = array (
          'data' =>
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
        );



      } else {
        //http://dev.cody.asia/api/posts?=page=1


        if (isset($_GET['page']) && $_GET['page'] > 0) {
          $currentPage = intval($_GET['page']);
        }

        // fetched data from database
        $pid = 1;
        $uid = 1;
        $title = 'Title Holder - Page ' . $currentPage;
        $urlslug = 'first-post';
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

     }


   } //end of if posts

//print_r($_REQUEST);



  } else if ($method === 'PUT') {

  } else if ($method === 'DELETE') {

  }


echo $response;




 ?>
