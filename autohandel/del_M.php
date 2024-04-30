<?php
include "../conn.php";
require_once "../Login/utils.php";


$id =htmlentities($_POST['id'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$user_id =htmlentities($_POST['user_id'], ENT_QUOTES | ENT_IGNORE, "UTF-8");

$sql_s = "delete from Mitarbeiter where id = :id";
$sql = "delete from users where id = :userid";

$sql_s =oci_parse($conn,$sql_s);

oci_bind_by_name($sql_s,":id",$id);

$sql =oci_parse($conn,$sql);

oci_bind_by_name($sql,":userid",$user_id);

oci_execute($sql_s);
oci_execute($sql);

 echo custom_json_encode([
          "result" => "SUCCESS",
          
        ]);
?>

