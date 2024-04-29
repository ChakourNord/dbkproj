<?php
include "../conn.php";

$name = htmlentities($_POST['name'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$nachname = htmlentities($_POST['nachname'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$position = htmlentities($_POST['position'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$gehalt = intval(htmlentities($_POST['gehalt'], ENT_QUOTES | ENT_IGNORE, "UTF-8"));
$strasse = htmlentities($_POST['strasse'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$hausnummer = htmlentities($_POST['hausnummer'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$stadt = htmlentities($_POST['stadt'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$plz = htmlentities($_POST['plz'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$land = htmlentities($_POST['land'], ENT_QUOTES | ENT_IGNORE, "UTF-8");
$passwort = htmlentities($_POST['passwort'], ENT_QUOTES | ENT_IGNORE, "UTF-8");

$sql = "CALL add_mitarbeiter(:name, :nachname, :position, :gehalt, :strasse, :hausnummer, :stadt, :plz, :land, :passwort)";
$sql = oci_parse($conn, $sql);
oci_bind_by_name($sql, ":name", $name);
oci_bind_by_name($sql, ":nachname", $nachname);
oci_bind_by_name($sql, ":position", $position);
oci_bind_by_name($sql, ":gehalt", $gehalt);
oci_bind_by_name($sql, ":strasse", $strasse);
oci_bind_by_name($sql, ":hausnummer", $hausnummer);
oci_bind_by_name($sql, ":stadt", $stadt);
oci_bind_by_name($sql, ":plz", $plz);
oci_bind_by_name($sql, ":land", $land);
oci_bind_by_name($sql, ":passwort", $passwort);


oci_execute($sql);
header('Location: Mitarbeiter.php');
?>