<?php

require_once "../../includes/utils.php";
require_once "../../includes/database.php";

$input = $_POST;
//print_r ($input);
$db_dsn = "mysql:host=" . $db_server . ";dbname=workerdb;charset=utf8";

try {
  $conn = new PDO($db_dsn, $db_username, $db_password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $params = [];
  $query = 'SELECT
                users.id AS id_user,
                users.id_company,
                users.name,
                users.surname,
                users.photo_url,
                users.username,
                users.is_enabled

              FROM users
              LEFT JOIN companies ON companies.company_id_number = users.id_company
              WHERE users.is_active = 1
              AND companies.is_active = 1
              AND users.username = :username
              AND users.password = :password';
  if (isset($_GET["autologin"])) {
    $params["username"] = $_GET["username"];
    $params["password"] = encryptPassword($_GET["password"]);
  } else {
    $params["username"] = $input["username"];
    $params["password"] = encryptPassword($input["password"]);
  }

  $result = $conn->prepare($query);
  $result->execute($params);

  if ($result->rowCount() > 0) {
    $user_data = $result->fetch(PDO::FETCH_ASSOC);

    $roles = [];
    $params = [];
    $query = 'SELECT roles.code
                  FROM roles
                  LEFT JOIN users_roles ON users_roles.id_role = roles.id
                  LEFT JOIN users ON users.id = users_roles.id_user
                  WHERE roles.is_active = 1
                  AND users_roles.is_active = 1
                  AND users.id = :id_user';

    $params["id_user"] = $user_data["id_user"];

    $result = $conn->prepare($query);
    $result->execute($params);

    if ($result->rowCount() > 0) {
      foreach ($result as $role_row) {
        $roles[] = $role_row["code"];
      }
    }

    if ($user_data["is_enabled"]) {
      setcookie(
        "id_company",
        $user_data["id_company"],
        time() + 86400 * 30,
        "/"
      );
      setcookie("is_admin", 0, time() + 86400 * 30, "/");
      setcookie(
        "id_useraudit",
        $user_data["id_user"],
        time() + 86400 * 30,
        "/"
      );
      setcookie("logoaudit", 0, time() + 86400 * 30, "/");
      //setcookie("dbname", "workerdb", time() + 86400 * 30, "/");

      //if (in_array('RESCUER', $roles) || in_array('DRIVER', $roles) || in_array('NURSE', $roles) || isset($input['admin_panel'])) {
      if (isset($_GET["autologin"])) {
        createToken($user_data, $roles);
        header("Location: chooser.php");
        die();
      }
      if (in_array("ADMIN", $roles) || in_array("SUPERADMIN", $roles)) {
        createToken($user_data, $roles);

        echo custom_json_encode([
          "result" => "SUCCESS",
          "message" => "Login Success"
        ]);
      } else {
        createToken($user_data, $roles);
        echo custom_json_encode([
          "result" => "SUCCESS",
          "message" => "Login Success"
        ]);
      }
    } else {
      echo custom_json_encode([
        "result" => "ERROR",
        "message" => "Loginfailed",
      ]);
    }
  } else {
    echo custom_json_encode([
      "result" => "ERROR",
      "message" => "Username or password incorrect",
    ]);
  }
} catch (Exception $e) {
  echo custom_json_encode([
    "result" => "ERROR",
    "message" => $e->getMessage(),
  ]);
}