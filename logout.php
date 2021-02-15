<?php  
session_start();

// hancurkan session
session_destroy();

header('Location: index.php');
?>