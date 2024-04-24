<?php
/*
logout php
*/
?>

<?php
require_once '../public/session.php';
$session = new session();
$session->forgetSession();
