<?php

unset($_SESSION['access_token']);
session_destroy();
header('Location:index.php');
