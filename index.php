<?php
if($_SERVER['REQUEST_URI'] === "/" || $_SERVER['REQUEST_URI'] === "/index.php") {
    header("Location: ./views/signup/login.php");
} else {
    header("Location: ./views/errors/404.php");
}

?>