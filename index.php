<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/PP_ACT/autenticacion.php";

// if tiene rol prestamista
header("Location: prestamista.php");
die();

// if tiene rol profesor
header("Location: profesor.php");
die();
?>