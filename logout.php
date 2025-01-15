<?php
session_start();
session_destroy();
header("Location: shop_owner_login.php");
exit;
?>
