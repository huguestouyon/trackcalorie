
<?php
session_start();
require_once "includes/header.php";
?>
<h1 class="text-center">TrackCalorie</h1>
<form action="" method="POST">
    <div>
        <input type="email" name="email" id="email" placeholder="Email">
    </div>
    <div>
        <input type="password" name="pass" id="pass" placeholder="Mot de passe">
    </div>
    <button type="submit">Me connecter</button>
</form>

<?php
require_once "includes/footer.php";
?>