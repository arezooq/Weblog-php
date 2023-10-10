<?php
require 'config/dbConfig.php';

session_destroy();
header('location: ../signin.php');
die();

?>