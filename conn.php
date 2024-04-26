
<?php
$conn = oci_connect('AUTOCHAKOUR','1234','localhost/ORCL','AL32UTF8');
if (!$conn) {
  echo "irgendwas klappt nicht schau du nach ";
  $e = oci_error();
  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
