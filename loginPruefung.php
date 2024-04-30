<?php
if (!isset($_POST["vUsername"]))
echo 'nicht angemeldet';
else
{
$c = oci_connect("iaf", "iaf", "localhost/ORCL");
$username = $_POST["vUsername"];
$kennwort = $_POST["vKennwort"];
$sql = "select count(*) from tblLogin where username = '$username' and  kennwort = '$kennwort'";

$s = oci_parse($c,$sql);
oci_execute($s);
$row=oci_fetch_row($s);
// echo $row[0];


if ($row[0] == 1)
{
session_start();	
$_SESSION["login"] = true;
echo 'Login als admin';
echo '<a href = geschuetzterBereich.php > geschuetzter Bereich </a>'; 
}

else

{
echo 'Passwort falsch <br>';
echo '<a href = login.php > neue Eingabe </a></br>';
echo '<a href = seitenStart.php > zum Start </a></br>';
}
}
?>