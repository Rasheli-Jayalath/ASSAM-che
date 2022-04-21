<?php
$user_cd = $objAdminUser->user_cd;
session_start();
$objAdminUser->setLogout();
redirect('./');
?>