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
                        <th class="text-center">ID_Calorie</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Calorie</th>
                        <th class="text-center">ID_Membre</th>
                        <th class="text-center">Date d'ajout</th>
                        <th class="text-center">Supprimer</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">ID_Calorie</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Calorie</th>
                        <th class="text-center">ID_Membre</th>
                        <th class="text-center">Date d'ajout</th>
                        <th class="text-center">Supprimer</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    require_once "../includes/connect.php";
                    $sql = "SELECT * FROM `calories`";
                    $query = $db->prepare($sql);
                    $query->execute();
                    $datas = $query->fetchAll();
                    foreach ($datas as $data => $value):
                        ?>
                        <tr>
                            <th class="text-center"><?= $value["id_calorie"] ?></th>
                            <th class="text-center"><?= $value["date"] ?></th>
                            <th class="text-center"><?= $value["calorie"] ?></th>
                            <th class="text-center"><?= $value["id_membre"] ?></th>
                            <th class="text-center"><?= $value["dateajout"] ?></th>
                            <th class="text-center">
                                <form action="calorie/suppr_calorie.php" method="GET">
                                    <input type="hidden" name="id_calorie" value="<?= $value['id_calorie']?>">
                                    <input type="hidden" name="id_membre" value="<?= $value['id_membre']?>">
                                    <input type="hidden" name="date" value="<?= $value['date']?>">
                                    <input type="submit" class="btn btn-outline-danger" value="❌">
                                </form>
                            </th>
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