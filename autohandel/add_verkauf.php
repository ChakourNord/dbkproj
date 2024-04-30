<?php
include "../conn.php";

$name = htmlentities($_POST['name'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$nachname = htmlentities($_POST['nachname'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$telefon = htmlentities($_POST['telefon'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$endpreis = htmlentities($_POST['Endpreis'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$id_fahrzeug = htmlentities($_POST['id_fahrzeug'], ENT_QUOTES | ENT_IGNORE, "UTF-8");

$sql = "CALL add_verkauf(:name, :nachname, :telefon,:endpreis,:id_fahrzeug)";
$sql = oci_parse($conn, $sql);
oci_bind_by_name($sql, ":name", $name);
oci_bind_by_name($sql, ":nachname", $nachname);
oci_bind_by_name($sql, ":telefon", $telefon);
oci_bind_by_name($sql, ":endpreis", $endpreis);
oci_bind_by_name($sql, ":id_fahrzeug", $id_fahrzeug);

oci_execute($sql);

header('Location: Fahrzeuge.php');
?>