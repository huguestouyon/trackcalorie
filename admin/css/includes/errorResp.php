<?php
    if (isset($_SESSION["error"])) {
        foreach ($_SESSION["error"] as $mes) {
    ?>
            <div class="error"><?= $mes ?></div>
    <?php
        }
        unset($_SESSION["error"]);
    }
    ?>