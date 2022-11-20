<nav>
    <div class="logo-nav">
        <img src="img/Logo calorie.svg" alt="">
        <div>
            <h1>TrackCalorie</h1>
    </div>
    </div>
    
    <div class="btn-nav">
    <?php 
    if(isset($_SESSION["admin"])):
    ?>
        <a href="../../trackcalorie/admin/index.php" id="del-kal"><button><i class="fa-solid fa-unlock"></i></button></a> <!-- Déconnexion -->
    <?php endif; ?>
    
    <button data-bs-toggle="modal" href="#exampleModalToggle" role="button"><i class="fa-solid fa-robot"></i></button> <!-- Ouvrir un modal -->
    <a href="deconnexion.php" id="del-kal"><button><i class="fa-solid fa-power-off"></i></button></a> <!-- Déconnexion -->
    </div>
</nav>
