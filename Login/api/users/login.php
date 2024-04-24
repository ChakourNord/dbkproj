<?php

require_once "../../utils.php";
require_once "../../../conn.php";



try {
  $params = [];
  $query = 'SELECT
                users.id AS id_user,
                users.name,
                users.surname,
                

              FROM users
              
              WHERE
              users.username = :username
              AND users.passwort = :password';


  $q = oci_parse($conn,$query);
  oci_bind_by_name($q, ':username',$_POST['username']);
  oci_bind_by_name($q, ':password',$_POST['password']);

  oci_execute($q);

  $row = oci_fetch_array($s, OCI_ASSOC+OCI_RETURN_NULLS);

  setcookie('user_id',$row['id_user'], time() + (86400 * 30), "/");
  if ($row > 0) {
        echo custom_json_encode([
          "result" => "SUCCESS",
          "message" => "Login Success"
        ]);}
} catch (Exception $e) {
  echo custom_json_encode([
    "result" => "ERROR",
    "message" => $e->getMessage(),
  ]);
}