<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Evntit">
<meta name="author" content="Michael Quattrochi">
<?php
require_once 'core/init.php';
$relPath = substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']));


echo"<title>Evntit</title>";
echo"<link rel=\"stylesheet\" href=\"$relPath/bower_components/bootstrap/dist/css/bootstrap.min.css\">";
echo"<link rel=\"stylesheet\" href=\"$relPath/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css\">";

echo"<link href=\"$relPath/bower_components/font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\" media=\"all\">";
echo"<link rel=\"stylesheet\" href=\"$relPath/css/styles.css\">";
echo"<link rel=\"stylesheet\" href=\"$relPath/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css\">";
echo"<script src=\"$relPath/bower_components/color-thief/dist/color-thief.min.js\"></script>";



?>


    <link href='https://fonts.googleapis.com/css?family=Open+Sans:100,400,600,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,300italic,100italic' rel='stylesheet' type='text/css'>
<body>
<div class='navbar-toggle' title='Menu'>
    <div class='bar1'></div>
    <div class='bar2'></div>
    <div class='bar3'></div>
</div>
<nav class="nav-hide">
    <ul>
        <?php
        echo"<li><a href=\"$relPath/index\">Home</a></li>";
        echo"<li><a href=\"$relPath/#\">Find Events</a></li>";
        $user = new User();
        if($user->isLoggedIn()){
            $un = $user->data()->email;
            echo"<li><a href=\"$relPath/create\">Create Event</a></li>";
            echo"<li><a href=\"#\">Profile</a></li>";
            echo"<li><a href=\"#\">Change Password</a></li>";
            echo"<li><a href=\"$relPath/logout\">Logout</a></li>";
            echo"</ul>";
            echo"</li>";
        }else{
            echo "<li><a href=\"$relPath/login\">Login</a>";
        }
        ?>
    </ul>
</nav>









