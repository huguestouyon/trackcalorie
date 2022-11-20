<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: connexion.php");
    exit;
}
require_once "includes/headeradmin.php";
require_once "includes/menu.php"; 
require_once "includes/navbaradmin.php"; 
?>
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- 404 Error Text -->
                    <div class="text-center">
                        <div class="error mx-auto" data-text="404">404</div>
                        <p class="lead text-gray-800 mb-5">Page Not Found</p>
                        <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
                        <a href="index.php">&larr; Retour Dashboard</a>
                    </div>

                </div>
                <!-- /.container-fluid -->
<?php echo realpath("../404.html"); ?>
<?php 
require_once "includes/footeradmin.php";
?>
