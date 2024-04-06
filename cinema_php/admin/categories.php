<?php
require_once "../inc/functions.inc.php";

if (!isset($_SESSION['user'])) {

    header("location:" . RACINE_SITE . "authentification.php");
} else {

    if ($_SESSION['user']['role'] == 'ROLE_USER') {

        header("location:" . RACINE_SITE . "index.php");
    }
}

if (isset($_GET['action']) && isset($_GET['id_category'])) {

    if (!empty($_GET['action']) && $_GET['action'] == 'update' && !empty($_GET['id_category'])) {

        $idCategory = $_GET['id_category'];
        $category = showCata($idCategory);
    }
}




$info = '';

if (!empty($_POST)) {

    $verif = true;

    foreach ($_POST as $value) {

        if (empty($value)) {

            $verif = false;
        }
    }

    if (!$verif) {

        $info = alert("Tous les champs sont requis", "danger");
    } else {

        $nameCategory = isset($_POST['name']) ? $_POST['name'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;

        if (strlen($nameCategory) < 3 || preg_match('/[0-9]+/', $nameCategory)) {

            $info = alert("Le champ nom de la catégorie n'est pas valide", "danger");
        }

        if (strlen($description) < 50) {

            $info .= alert("Il faut que la déscription dépasse 50 caractères", "danger");
        }

        if (empty($info)) {

            // debug($_POST);

            $nameCategory = strip_tags($nameCategory);
            $description = strip_tags($description);

            addCategory($nameCategory, $description);

            // header('location:dashboard.php?categories_php');
            $info = alert('Catégorie ajoutée avec succés', 'success');
        }
    }
}


$title = "Categories";
require_once "../inc/header.inc.php";

?>

<div class="row mt-5">
    <div class="col-sm-12 col-md-6 mt-5">
        <h2 class="text-center fw-bolder mb-5 text-danger">Ajout de catégories</h2>
        <?php
        echo $info;

        ?>
        <form action="" method="post">
            <div class="row">
                <div class="col-md-8 mb-5">
                    <label for="name">Nom de la catégorie</label>
                    <input type="text" id="name" name="name" class="form-control" value="">

                </div>
                <div class="col-md-12 mb-5">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="10" class="form-control"></textarea>
                </div>
                <div class="row">
                    <button type="submit" class="w-50 btn btn-danger btn-lg fw-bolder fs-5 p-3">Ajouter</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-12 col-md-6 mt-5">
        <h2 class="text-center fw-bolder mb-5 text-danger">Liste des catégories</h2>
        <?php

        $categories = allCategories();
        // debug($categories);

        ?>
        <table class="table table-dark table-bordered mt-5">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Supprimer</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody>
                <?php

                 //$categories= allCategories();
                foreach ($categories as $category) {

                ?>
                    <tr>
                        <td><?= $category['id_category'] ?></td>
                        <td><?= html_entity_decode(ucfirst($category['name'])) ?></td>
                        <td><?= substr(html_entity_decode(ucfirst($category['description'])), 0, 40) . "...." ?></td>
                        <td><?php ?><a href="?categories_php&action=delete&id_category=<?=$category['id_category']?>">
                        <i class="bi bi-trash3-fill text-danger"></i>
                        </a></td>

                        <td><?php ?><a href="?categories_php&action=update&id_category=<?=$category['id_category']?>">
                        <i class="bi bi-pen-fill text-info"></i></a>
                        </td>

                    </tr>

                <?php
                }

                ?>
            </tbody>
        </table>

    </div>

</div>


<?php
require_once "../inc/footer.inc.php";
?>