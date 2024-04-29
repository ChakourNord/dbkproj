<?php
include "../conn.php";
require_once "../Login/utils.php";


$id =htmlentities($_POST['id'], ENT_QUOTES | ENT_IGNORE, "UTF-8");

$sql = "delete from Mitarbeiter where id = :id";

$sql =oci_parse($conn,$sql);

oci_bind_by_name($sql,":id",$id);

oci_execute($sql);

 echo custom_json_encode([
          "result" => "SUCCESS",
          
        ]);
?>

