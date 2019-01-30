<?php
require_once('includes.php');

$debug = 0;
$response = '';
$rawResponse = '';
$mysqltime = date ("Y-m-d H:i:s");

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

    if ($key1 == 'posts') {

      if (isset($obj['image'])) { $image = mysqli_real_escape_string($obj['image']); } else { $image = ''; }
      if (isset($obj['title'])) { $title = sanitize($obj['title']); } else { $title = ''; }
      if (isset($obj['content'])) { $content = mysqli_real_escape_string($obj['content']); } else { $content = ''; }

      $rawResponse = array (
        'data' =>
        array (
          'title' => 'first post',
          'content' => 'content of the post',
          'slug' => 'first-post',
          'updated_at' => '2019-01-23 02:06:06',
          'created_at' => '2019-01-23 02:06:06',
          'id' => 1,
          'user_id' => 1,
        ),
      );

      header("HTTP/1.1 201 Created");
      echo json_encode($rawResponse);

} // End of posts key1

    if ($key1 == 'login') {
      // http://dev.cody.asia/api/login

      $json = @file_get_contents('php://input');
      $obj = json_decode($json, true);

      // Get form params and sanitize
      if (isset($obj['email'])) { $email = sanitize($obj['email']); } else { $email = ''; }
      if (isset($obj['password'])) { $password = sanitize($obj['password']); } else { $password = ''; }


      // Check if Authenticated User
      if ($email == 'islarky88@gmail.com' && $password == 'password') {

        $date = strtotime("+7 day");
        $date = date('Y-m-d H:i:s', $date);

        $rawResponse = array (
          'token' => md5($email.$password),
          'token_type' => 'bearer',
          'expires_at' => $date,
        );

        echo json_encode($rawResponse);

      } else { // If user/pass combination is wrong


        $rawResponse = array (
                  'message' => 'Login Error.',
                );

        if ($email == '') {
          $rawResponse['errors']['email'] = 'The email field is required.';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $rawResponse['errors']['email'] = 'Email address is not a valid format.';
        }

        if ($password == '') {
          $rawResponse['errors']['password'] = 'The password field is required.';
        } else {
          $rawResponse['errors']['password'] = 'User/Pass combination is incorrect.';
        }


        header("HTTP/1.1 422 Unprocessable Entity");
        //  print_r($rawResponse);
        echo json_encode($rawResponse);

      } //end of login check


    } //end of key1 login

    if ($key1 == 'logout') {

      $rawResponse = array (
        'logout' => 'success',
      );

      echo json_encode($rawResponse);

      //CLEAR COOKIE, TOKEN, AUTHENTICATION, ETC CODE
      //logout();

    }

    if ($key1 == 'register') {

      // Get form params and sanitize

      $json = @file_get_contents('php://input');
      $obj = json_decode($json, true);

    //  print_r($obj);

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
        header("HTTP/1.1 201 Created");
        echo json_encode($rawResponse);


      } else { //Registration errors

        $rawResponse = array (
                  'message' => 'Registration Error.',
                );

        if ($name == '') {
          $rawResponse['errors']['name'] = 'The name field is required.';
        }

        if ($email == '') {
          $rawResponse['errors']['email'] = 'The email field is required.';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $rawResponse['errors']['email'] = 'Email address is not a valid format.';
        }

        if ($password == '') {
          $rawResponse['errors']['password'] = 'The password field is required.';
        } else if ($password != $passwordConfirmation) {
          $rawResponse['errors']['password'] = 'Passwords do not match.';
        }


        header("HTTP/1.1 422 Unprocessable Entity");
        //  print_r($rawResponse);
        echo json_encode($rawResponse);

      } // End of registration

    } //end of key1 login

  } else if ($method === 'GET') {

    //echo $_GET['page'];

    if ($key1 == 'posts') {

      if ($key2 != '') { // this depends on the post URL slug

        if ($key3 == 'comments') {
          // gets the comments
        // http://dev.cody.asia/api/posts/new-title/comments

          $rawResponse = array (
            'data' =>
            array (
              0 =>
              array (
                'id' => 1,
                'title' => NULL,
                'body' => 'content of the post',
                'commentable_type' => 'App\\Post',
                'commentable_id' => 1,
                'creator_type' => 'App\\User',
                'creator_id' => 1,
                '_lft' => 1,
                '_rgt' => 2,
                'parent_id' => NULL,
                'created_at' => '2019-01-23 02:09:12',
                'updated_at' => '2019-01-23 02:09:12',
              ),
            ),
          );


      } else {

        $newtitle = $key2;
        $slug = textToSlug($key2);

          $rawResponse = array (
            'data' =>
            array (
              'id' => 1,
              'user_id' => 1,
              'title' => $newtitle,
              'slug' => $slug,
              'content' => 'content of the post',
              'created_at' => '2019-01-23 02:06:06',
              'updated_at' => '2019-01-23 02:13:26',
              'deleted_at' => NULL,
            ),
          );

          echo json_encode($rawResponse);

        }

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

       echo json_encode($rawResponse);

     }

   } //end of if posts

  } else if ($method === 'DELETE') {
    //http://dev.cody.asia/api/posts/new-title

    if ($key1 == 'posts') {

      // comment delete
      if ($key3 == 'comments' && $key2 != '') {

        // Check if post exists

        // $query = intval($key4);
        // $result = $mysqli->query("SELECT * FROM comments WHERE id = '$query' LIMIT 1");
        // $main = $result->fetch_object();
        // $commentid = $main->id;

        if ($commentid != NULL) {

            // $mysqli->query("DELETE FROM posts WHERE `id` = '$id'");
            echo '{"status": "comment deleted successfully"}';

        } else {

            echo '{"status": "comment does not exist"}';

        }

      // post delete
      } else {

        // Check if post exists

        // $query = textToSlug($key2);
        // $result = $mysqli->query("SELECT * FROM posts WHERE url = '$query' LIMIT 1");
        // $main = $result->fetch_object();
        // $postid = $main->id;

        if ($postid != NULL) {

            // $mysqli->query("DELETE FROM posts WHERE `id` = '$id'");
            echo '{"status": "post deleted successfully"}';

        } else {

            echo '{"status": "post does not exist"}';

        }

      } // end of post delete

    } // end of delete of posts/comments


  } else if ($method === 'PATCH') {
    //http://dev.cody.asia/api/posts/first-post

    if ($key1 == 'posts') {

      // Check if post exists

      // $query = textToSlug($key2);
      // $result = $mysqli->query("SELECT * FROM posts WHERE url = '$query' LIMIT 1");
      // $main = $result->fetch_object();
      // $postid = $main->id;

      if ($postid != NULL) {

          //deletePost();
          $updatedTitle = 'Updated title';
          $updatedContent = 'Updated Lorem Ipsum Content Holder';
          $createPostDate = 'created at date here';

          $rawResponse = array(
              "data" => array(
                  "id" => 1,
                  "user_id" => 1,
                  "title" => $updatedTitle,
                  "slug" => textToSlug($updatedTitle),
                  "content" => $updatedContent,
                  "created_at" => $createPostDate,
                  "updated_at" => $mysqltime,
                  "deleted_at" => null
              )
          );

          echo json_encode($rawResponse);



      } else {

          echo '{"status": "post does not exist"}';

      }

    }

  }






 ?>
