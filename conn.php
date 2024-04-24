
<?php
$conn = oci_connect('autochackour', '1234', 'localhost:2221/ORCL', 'AL32UTF8');
if (!$conn) {

  echo "irgendwas klappt nicht schau du nach ";
  $e = oci_error();
  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
