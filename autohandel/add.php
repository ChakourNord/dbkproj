<?php
include "../conn.php";

$modell =htmlentities($_POST['modell'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$hersteller =htmlentities($_POST['hersteller'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$baujahr =intval(htmlentities($_POST['baujahr'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
$preis =intval(htmlentities($_POST['preis'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));

$sql = "CALL add_fahrzeug(:modell,:hersteller,:baujahr,:preis)";
$sql =oci_parse($conn,$sql);
oci_bind_by_name($sql,":modell",$modell);
oci_bind_by_name($sql,":hersteller",$hersteller);
oci_bind_by_name($sql,":baujahr",$baujahr);
oci_bind_by_name($sql,":preis",$preis);

oci_execute($sql);
header('Location: Fahrzeuge.php');
?>