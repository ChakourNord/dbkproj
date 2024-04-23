<?php
session_start();	
if (isset($_SESSION["login"]))
{
	echo 'geschuetzter Bereich, sie sind angemeldet <br>';
	
	echo '<form action="logout.php" method = "POST">
	Abmelden
	<input type ="submit" value="abmelden" />
	</form>';
}
else
{
echo 'nicht angemeldet';
}
?>
