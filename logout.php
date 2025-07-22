<?php
setcookie("user", "", time()-1, "/");
header("location: Log.php");
exit;

?>