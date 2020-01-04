<?php
include "db.php";
include "../admin/functions.php";
session_start();
?>



<?php

if(isset($_POST['login'])) {
    login_user($_POST['username'], $_POST['password']);
}


?>
