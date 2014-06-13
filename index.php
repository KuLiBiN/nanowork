<?php
session_start();
require_once('lib/mysql.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nanowork for VK</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Nanowork</a>
    </div>
    <div class="navbar-collapse collapse navbar-responsive-collapse" id="menu"></div>
</div>

<div class="container-fluid" id="content"></div>


<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>