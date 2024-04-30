<?php

if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
  exit();
}


// require_once($autoload);

define("HASH_KEY_PASSWORD", "-#_H45h_K3y_4bb4574n24_51cur4_#-");
define("HASH_KEY_TOKEN", "@#_P455w0rd_P3r_G3n3r4r3_1l_70k3n_#@");

function formatDateold($date, $format)
{
  if (!$date) {
    return null;
  }

  return date($format, strtotime(str_replace("/", "-", $date)));
}

function formatTime($time)
{
  return substr($time, 0, 5);
}

function bitToYesNo($bit)
{
  settype($bit, "integer");

  return $bit === 0 ? "No" : "Si";
}

function checkIsNull($value, $default = null)
{
  return $value ? $value : $default;
}

function checkKeyExists($array, $key, $default = [])
{
  return array_key_exists($key, $array) ? $array[$key] : $default;
}

function createToken($user_data)
{
  $expiring_date = new DateTime();
  $expiring_date->add(new DateInterval("PT10H")); // Current time + 10 hours

  $encoded_header = base64_encode(
    json_encode([
      "alg" => "HS256",
      "typ" => "JWT",
    ])
  );

  $encoded_payload = base64_encode(
    json_encode([
      "id_user" => $user_data["ID"],
      "username" => $user_data["USERNAME"],
    ])
  );

  $header_payload = $encoded_header . "." . $encoded_payload;
  $signature = base64_encode(
    hash_hmac("sha256", $header_payload, HASH_KEY_TOKEN, true)
  );
  $jwt_token = $header_payload . "." . $signature;

  setcookie("tokenaudit", $jwt_token, $expiring_date->getTimestamp(), "/");
}

function checkToken()
{
  // $check_token_only = !is_array($roles);
  //$check_token_only = "";

  if (array_key_exists("tokenaudit", $_COOKIE)) {
    $token = $_COOKIE["tokenaudit"];

    $jwt_values = explode(".", $token);
    $header_payload = $jwt_values[0] . "." . $jwt_values[1];
    $signature = $jwt_values[2];

    $resulted_signature = base64_encode(
      hash_hmac("sha256", $header_payload, HASH_KEY_TOKEN, true)
    );
    $payload = json_decode(base64_decode($jwt_values[1]));

    if ($resulted_signature === $signature) {
      
        return [
          "allowed" => true,
          "id_user" => $payload->id_user,
          "username" => $payload->username,
        ];
      

      // foreach ($payload->roles as $role) {
      //   if (in_array($role, $roles)) {
      //     return [
      //       "allowed" => true,
      //       "id_user" => $payload->id_user,
      //       "username" => $payload->username
      //     ];
      //   }
      // }
    } else {
      destroyToken();
    }
  }

  return $check_token_only
    ? false
    : [
      "allowed" => false,
    ];
}

function destroyToken()
{
  unset($_COOKIE["tokenaudit"]);
  setcookie("tokenaudit", null, -1, "/");
}

function encryptString($plain_text, $key)
{
  $method = "aes-256-cbc";
  $key = substr(hash("sha256", $key, true), 0, 32);

  $iv =
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0);

  $encrypted = base64_encode(
    openssl_encrypt($plain_text, $method, $key, OPENSSL_RAW_DATA, $iv)
  );

  return $encrypted;
}

function decryptString($encrypted_text, $key)
{
  $method = "aes-256-cbc";
  $key = substr(hash("sha256", $key, true), 0, 32);

  $iv =
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0) .
    chr(0x0);

  $decrypted = openssl_decrypt(
    base64_decode($encrypted_text),
    $method,
    $key,
    OPENSSL_RAW_DATA,
    $iv
  );

  return $decrypted;
}

function encryptPassword($plain_text)
{
  return encryptString($plain_text, HASH_KEY_PASSWORD);
}

function decryptPassword($encrypted_text)
{
  return decryptString($encrypted_text, HASH_KEY_PASSWORD);
}

function reArrayFiles(&$file_post)
{
  $file_ary = [];
  $file_count = count($file_post["name"]);
  $file_keys = array_keys($file_post);

  for ($i = 0; $i < $file_count; $i++) {
    foreach ($file_keys as $key) {
      $file_ary[$i][$key] = $file_post[$key][$i];
    }
  }

  return $file_ary;
}

function genUuid()
{
  return sprintf(
    "%04x%04x-%04x-%04x-%04x-%04x%04x%04x",
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0x0fff) | 0x4000,
    mt_rand(0, 0x3fff) | 0x8000,
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff)
  );
}

function getLimits($number_results, $page)
{
  $limits_query = "";
  $limits_params = [];

  if ($number_results !== null && $page !== "") {
    $offset = ($page - 1) * $number_results;

    $limits_query .= "LIMIT :offset, :number_results ";
    $limits_params = [
      "offset" => $offset,
      "number_results" => $number_results,
    ];
  }

  return [
    "query" => $limits_query,
    "params" => $limits_params,
  ];
}

function base64ToFile($data)
{
  list($type, $data) = explode(";", $data);
  list(, $data) = explode(",", $data);
  return base64_decode($data);
}

function custom_json_encode($array)
{
  return json_encode($array, JSON_NUMERIC_CHECK);
}

function parseError($message)
{
  if (
    stringContains($message, "Duplicate entry") &&
    stringContains($message, "for key 'username'")
  ) {
    return "Questo username è già utilizzato da un altro utente.";
  } elseif (
    stringContains($message, "Duplicate entry") &&
    stringContains($message, "for key 'email'")
  ) {
    return "Questa email è già utilizzata da un altro utente.";
  }
  return $message;
}

function stringContains($string, $value)
{
  if (strpos($string, $value) !== false) {
    return true;
  }
  return false;
}

function emptyToNull($val)
{
  if ($val == "") {
    return null;
  } else {
    return $val;
  }
}

function emptyToNullString($val)
{
  if ($val == "") {
    return "NULL";
  } else {
    return $val;
  }
}

function emptyToZero($val)
{
  if ($val == "") {
    return 0;
  } else {
    return $val;
  }
}
