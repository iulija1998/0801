<?php
header('Content-Type: text/html; charset=utf-8');
$mysqli = mysqli_connect("localhost", "waychtsu_abc0207","111", "waychtsu_abc0207");
if ($mysqli == false) {
  print("error");
} else {
  $email = trim(mb_strtolower($_POST['email']));
  $pass = trim($_POST['pass']);

  $result = $mysqli->query("SELECT * FROM `users` WHERE `email` = '$email'");
  //var_dump($result);
  $result = $result->fetch_assoc();

  //var_dump($result["pass"]);
  if (password_verify($pass, $result['pass'])) {
    echo "ok";
    $_SESSION['name'] = $result['name'];
    $_SESSION['lastname'] = $result['lastname'];
    $_SESSION['email'] = $result['email'];
    $_SESSION['id'] = $result['id'];
  }else{
    echo "user_not_found";
  }
}


?>
