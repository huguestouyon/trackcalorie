<div class="modal fade bg-dark" id="exampleModalToggle" aria-labelledby="exampleModalToggleLabel" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel"><?= "Hey " . $_SESSION["user"]["name"] ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="add-tab" data-bs-toggle="tab" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="true"><i class="fa-solid fa-plus"></i></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="suppr-tab" data-bs-toggle="tab" data-bs-target="#suppr" type="button" role="tab" aria-controls="suppr" aria-selected="false"><i class="fa-solid fa-minus"></i></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#user" type="button" role="tab" aria-controls="user" aria-selected="false"><i class="fa-solid fa-user"></i></button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="setting-tab" data-bs-toggle="tab" data-bs-target="#setting" type="button" role="tab" aria-controls="setting" aria-selected="false"><i class="fa-solid fa-gear"></i></button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="add" role="tabpanel" aria-labelledby="add-tab">
                        <h3 class="pt-3">Ajoute des calories</h3>
                        <form action="addkal.php" method="post">
                            <div class="form-group pt-2">
                                <input type="number" class="form-control" name="kalnb" id="kalnb" placeholder="Nombre de calories" min="0" max="8000" required>
                            </div>
                            <div class="form-group pt-2">
                                <input type="date" class="form-control" name="kaldate" id="kaldate" placeholder="Choisir une date" required>
                            </div>
                            <div class="pt-2 text-center">
                                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-plus"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="suppr" role="tabpanel" aria-labelledby="suppr-tab">
                        <h3 class="pt-3">Supprime des calories</h3>
                        <form action="supprkal.php" method="post">
                            <div class="form-group pt-2">
                                <input type="date" class="form-control" name="supprdate" id="supprdate" placeholder="Choisir une date" required>
                            </div>
                            <div class="pt-2 text-center">
                                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-minus"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="user" role="tabpanel" aria-labelledby="user-tab">
                        <h3 class="pt-3">Modifie tes données</h3>
                        <form>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Prénom">
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Nom">
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-cake-candles"></i></span>
                                </div>
                                <input type="date" class="form-control" placeholder="Date de naissance">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-br-none"><i class="fa-sharp fa-solid fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Numéro de téléphone" max="" min="0">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-br-none"><i class="fa-sharp fa-solid fa-medal"></i></span>
                                </div>
                                <input type="number" class="form-control" placeholder="Nombre d'heure(s) de sport hebdomadaire">
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="Taille">
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" placeholder="Poids">
                                </div>
                            </div>
                            <div class="pt-2 text-center">
                                <button class="btn btn-outline-dark" type="submit">Modifier les informations</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="setting-tab">
                        <h3 class="pt-3">Paramètres</h3>
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Modification du mot de passe
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form action="new-pass.php" method="post">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-key"></i></span>
                                                </div>
                                                <input type="password" name="oldpswd" class="form-control" placeholder="Ancien mot de passe">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-key"></i></span>
                                                </div>
                                                <input type="password" name="newpswd1" class="form-control" placeholder="Nouveau mot de passe">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-key"></i></span>
                                                </div>
                                                <input type="password" name="newpswd2" class="form-control" placeholder="Retaper nouveau mot de passe">
                                            </div>
                                            <div class="pt-2 text-center">
                                                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-pen"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Modification de l'adresse email
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                    <form action="new-email.php" method="post">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-envelope"></i></span>
                                                </div>
                                                <input type="email" name="oldemail" class="form-control" placeholder="Ancienne adresse email">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-envelope"></i></span>
                                                </div>
                                                <input type="email" name="newemail1" class="form-control" placeholder="Nouvelle adresse email">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-envelope"></i></span>
                                                </div>
                                                <input type="email" name="newemail2" class="form-control" placeholder="Retaper nouvelle adresse email">
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text input-br-none"><i class="fa-solid fa-key"></i></span>
                                                </div>
                                                <input type="password" name="pswd" class="form-control" placeholder="Mot de passe">
                                            </div>
                                            <div class="pt-2 text-center">
                                                <button class="btn btn-outline-dark" type="submit"><i class="fa-solid fa-pen"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>