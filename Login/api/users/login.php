<?php

require_once "../../utils.php";
require_once "../../../conn.php";



try {
  $params = [];
  $query = 'SELECT
                users.id,
                users.name,
                users.surname
              FROM users
              WHERE
              users.username = :username
              AND users.passwort = :passwort';




  $q = oci_parse($conn,$query);
  oci_bind_by_name($q, ":username",$_POST['username']);
  oci_bind_by_name($q, ":passwort",$_POST['password']);
  oci_execute($q);
     


  $row = oci_fetch_array($q, OCI_ASSOC+OCI_RETURN_NULLS);

 
  if ($row > 0) { 
    session_start();
    $_SESSION['user_id'] = $row['ID'];
    setcookie('user_id',$row['ID'], time() + (86400 * 30), "/");
        echo custom_json_encode([
          "result" => "SUCCESS",
          "message" => "Login Success"
        ]);}
        else{
          echo custom_json_encode([
            "result" => "ERROR",
            "message" => "Login failed"
          ]);
        }
} catch (Exception $e) {
  echo custom_json_encode([
    "result" => "ERROR",
    "message" => $e->getMessage(),
  ]);
}