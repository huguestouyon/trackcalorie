<?php
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function timeoutlogout() {
    if(time() - $_SESSION["last_time"] > 60) {
        header("Location: deconnexion.php");
    }
    else {
        $_SESSION["last_time"] = time();
    }
}

?>