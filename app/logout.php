<?php
session_destroy();

// unset($_SESSION['user']);
// unset($_SESSION['uid']);
// unset($_SESSION['admin']);
header("Location: /");
?>