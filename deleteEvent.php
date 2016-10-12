<?php
$relPath = realPath($_SERVER['DOCUMENT_ROOT']);
require_once ("$relPath/core/init.php");
$eventID = Input::get('id');
echo $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$e = new Events();
$e->delete($eventID);

