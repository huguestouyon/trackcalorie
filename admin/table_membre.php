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
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Information sur les membres</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Taille</th>
                        <th>Poids</th>
                        <th>Genre</th>
                        <th>Role(s)</th>
                        <th>Date d'inscription</th>
                        <th>Tel</th>
                        <th>Sport</th>
                        <th>Date d'anniversaire</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Taille</th>
                        <th>Poids</th>
                        <th>Genre</th>
                        <th>Role(s)</th>
                        <th>Date d'inscription</th>
                        <th>Tel</th>
                        <th>Sport</th>
                        <th>Date d'anniversaire</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    require_once "../includes/connect.php";
                    $sql = "SELECT * FROM `membres`";
                    $query = $db->prepare($sql);
                    $query->execute();
                    $datas = $query->fetchAll();
                    foreach ($datas as $data => $value):
                        ?>
                        <tr>
                            <th><?= $value["id"] ?></th>
                            <th><?= $value["nom"] ?></th>
                            <th><?= $value["prenom"] ?></th>
                            <th><?= $value["email"] ?></th>
                            <th><?= $value["taille"] ?></th>
                            <th><?= $value["poids"] ?></th>
                            <th><?= $value["sexe"] ?></th>
                            <th><?= $value["id"] ?></th>
                            <th><?= $value["dateinscription"] ?></th>
                            <th><?= $value["tel"] ?></th>
                            <th><?= $value["sport"] ?></th>
                            <th><?= $value["dateinscription"] ?></th>
                        </tr>
                    <?php
                    endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<?php
require_once "includes/footeradmin.php";
?>