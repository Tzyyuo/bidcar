<?php
session_start();
session_destroy();
header("Location: /bidcar/views/login.php");
?>