<?php
require_once("assets/interface.php");
$Sesion->setDateDeath(date("Y-m-d H:i:s"));
$DaoSesiones->update($Sesion);
setcookie("SessionUID", "", time() - (86400 * 2), "/");
header("Location: /login");
exit();
