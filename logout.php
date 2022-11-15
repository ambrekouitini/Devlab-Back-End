<?php
session_start();
unset($_SESSION['email']);
unset($_SESSION['role']);
header('Location: login.php');