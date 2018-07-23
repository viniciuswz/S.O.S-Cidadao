<?php
session_start();
session_destroy();
header("Location: ./Templates/loginTemplate.php");