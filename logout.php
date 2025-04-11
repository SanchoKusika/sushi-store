<?php
require("config.php");
require(ROOT . "functions/auth.php");

logout_user();

header("Location: index.php");
exit;
