<?php
if (isset($_SESSION["validinsertcalorie"])) {
        foreach ($_SESSION["validinsertcalorie"] as $message) {
    ?>
            <div class="valid"><?= $message ?></div>
    <?php
        }
        unset($_SESSION["validinsertcalorie"]);
    }
?>