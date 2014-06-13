<?php

if (isset($_SESSION['uid']) || isset($_GET['uid'])){

    if (isset($_SESSION['uid'])){
        $uid=intval($_SESSION['uid']);
    }
    if (isset($_GET['uid'])){
        $uid=intval($_GET['uid']);
    }

    $q=mysqli_query($main_db, 'SELECT * FROM `users` WHERE `id`='.$uid.' LIMIT 1');

    if (mysqli_num_rows($q)>0){
        $user=mysqli_fetch_assoc($q);
        $_SESSION['uid']=$uid;
    }



}

print_r($user);