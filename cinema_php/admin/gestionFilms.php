<?php

require_once "../inc/functions.inc.php";

if(!isset($_SESSION['user'])) {
    header("location:".RACINE_SITE."authentification.php");
}else{
    if($_SESSION['user']['role'] == 'ROLE_USER'){
        header("location:".RACINE_SITE."index.php");
    }
}

/////////////////////////////////////

if (isset($_GET['action']) && isset($_GET['id_film'])) {

    if (!empty($_GET['action']) && $_GET['action'] == 'update' && !empty($_GET['id_film'])) {

        $idFilm = $_GET['id_film'];
        $film = showFilm($idFilm);
    }

    if (isset($_GET['action']) && isset($_GET['id_film'])) {
        if (!empty($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['id_film'])) {
    
            $idCategory = $_GET['id_film'];
            $category = deleteFilm($idCategory);
        }
    }
}

/////////////////////////////////

$info = '';

if (!empty($_POST)) {
    // debug($_POST);
    $verif = true;

    foreach ($_POST as $value) {

        if(empty(trim($value))) {
            $verif = false;
        }
    }
    // la superLobal $_FILES a un indice "image" qui correspond au "name" de l'input type="file" du formulaire, ainsi qu'un indice "name" qui contient le nom du fichier en cours de téléchargement.

    if (!empty($_FILES['image']['name'])) {  //si le nom du fichier en cours de téléchargement n'est pas vide, alors c'est qu'on est entrain de télécharger une photo
        // debug($_FILES);

        $image = $_FILES['image']['name']; //$image contient le chemi relatif de la photo et sera enregistré en BDD. On utilise ce chemin pour les "src" des balises <img>.

        // copy($_FILES['image']['tmp_name'], '../assets/'.$image);

        //On enregistre le ficher image qui se trouve à l'adresse contenue dan $_FILES['image']['tmp_name'] vers la destination qui est le dossier "img" à l'adresse

    }

  

    if (!$verif || empty($image)) {

        $info = alert("Tout les champs sont requis", "danger");
        
    }
    // else{

    // ///////////////////////////////////////////////////////////////////////
    // $maxSize = 5000000; // Je choisi une taille maximale pour les photos

    // $extensions = array('.jpg', '.jpeg'); // Je choisis les extensions des photos
    // $extension = strrchr($_FILES['image']['name'], '.'); // affiche .jpg
    // }
    
    // if (!in_array($extension, $extensions)) // Si l'extensionn'est pas dans le tableau
    // {
    //     echo 'Vous devez uploader un fichier de type JPEG ou JPG';
    // }

    // if ($_FILES['image']['size'] > $maxSize) {
    //     echo 'ALERT';
    // }

     //$_FILES['image']['name']NOM
    //$_FILES['image']['type']TYPE
    //$_FILES['image']['size']TAILLE
    //$_FILES['image']['tmp-name']EMPLACEMENT TEMPORAIRE
    //$_FILES['image']['error']ERREUR SI oui/non l'image a été réceptionné

    // if ($_FILES['image']['error'] != 0 || $_FILES['image']['size'] == 0 || !isset($_FILES['image']['type'])) {
    //     $info = alert("L'image n'est pas valide", "danger");
    // }

    if (!isset($_POST['title']) || (strlen($_POST['title']) < 3 && trim($_POST['title'])) || preg_match('/[0-9]+/', $_POST['title'])) {


        $info .= alert("Le champ titre n'est pas valide", "danger");
    }

    if (!isset($_POST['director']) || (strlen($_POST['director']) < 2 && trim($_POST['director'])) || preg_match('/[0-9]+/', $_POST['director'])) {

        $info .= alert("Le champs Réalisateur n'est pas valide", "danger");
    }
    //Explications: 
    //    .* : correspond à n'importe quel nombre de caractères (y compris zéro caractère), sauf une nouvelle ligne.
    //     \/ : correspond au caractère /. Le caractère / doit être précédé d'un backslash \ car il est un caractère spécial en expression régulière. Le backslash est appelé caractère d'échappement et il permet de spécifier que le caractère qui suit doit être considéré comme un caractère ordinaire.
    //     .* : correspond à n'importe quel nombre de caractères (y compris zéro caractère), sauf une nouvelle ligne.


    if (!isset($_POST['actors']) || (strlen($_POST['actors']) < 3 && trim($_POST['actors'])) || preg_match('/[0-9]+/', $_POST['actors'])) {

        $info .= alert("Le champs acteurs n'est pas valide", "danger");
    } 

    if (!isset($_POST['categories'])) {

        $info .= alert("Le champs catégories n'est pas valide", "danger");
    }

    if (!isset($_POST['synopsis']) || strlen($_POST['synopsis']) < 50) {

        $info .= alert("Le champs synopsis n'est pas valide", "danger");
    }

    if (!isset($_POST['duration'])) {

        $info .= alert("Le champs duration n'est pas valide", "danger");
    }

    if (!isset($_POST['date'])) {

        $info .= alert("Le champs date n'est pas valide", "danger");
    }

    if (!isset($_POST['price']) || !is_numeric($_POST['price'])) {

        $info .= alert("Le prix n'est pas valide", "danger");
    }

    if (!isset($_POST['stock'])) {

        $info .= alert("Le stock n'est pas valide", "danger");
    }



    //S'il n y a pas d'erreur sur le formulaire
    if (empty($info)) {

        $title = htmlentities(trim($_POST['title']));
        $director = htmlentities(trim($_POST['director']));
        $actors = htmlentities(trim($_POST['actors']));
        $category = $_POST['categories'];
        $duration = $_POST['duration'];
        $synopsis = htmlentities(trim($_POST['synopsis']));
        $dateSortie = $_POST['date'];
        $image = $_FILES['image']['name'];
        $price = (float) htmlentities(trim($_POST['price']));
        $stock = (int) $_POST['stock'];
        $ageLimit = $_POST['ageLimit'];

        // copy($_FILES['image']['tmp_name'], '../assets/'.$image);
        // On enregistre le fichier image qui se trouve à l'adresse contenue dans $_FILES['image']['tmp_name'] vers la destination qui est le dossier "img" à l'adresse "../assets/nom_du_fichier.jpg".
        
        // debug($image);

        // $idCategory = idCategory($category);
            // $category_id = $idCategory['id_category'];

            if ($_GET['action'] == "update") {
                updateFilm($id_film, $category, $title, $director, $actors, $ageLimit, $duration, $synopsis, $dateSortie, $price, $stock);
                // move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/' . $image);

                if ($_FILES['image']['size'] > 0) {
                    $pdo = connexionBdd();
                    // $sql = "INSERT INTO films(image) VALUE(:image) WHERE id_film = :id_film";
                    $sql = "UPDATE films SET image = :image WHERE id_film = :id_film";
                    $request = $pdo->prepare($sql);
                    $request->execute(array(
                        ":id_film" => $id_film,
                        ":image" => $image
                    ));

                    move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/' . $image);
                }
            } else {
                addFilm($category, $title, $director,  $actors,  $ageLimit,  $duration,  $synopsis,  $dateSortie, $image, $price, $stock);
                move_uploaded_file($_FILES['image']['tmp_name'], '../assets/img/' . $image);
            }
            header('Location: films.php');
        }
}


//         $title = isset($_POST['title']) ? $_POST['title'] : null;
//         $director = isset($_POST['director']) ? $_POST['director'] : null;
//         $actors = isset($_POST['actors']) ? $_POST['actors'] : null;
//         $category = isset($_POST['categories']) ? $_POST['categories'] : null;
//         $duration = isset($_POST['duration']) ? $_POST['duration'] : null;
//         $synopsis = isset($_POST['synopsis']) ? $_POST['synopsis'] : null;
//         $dateSortie = isset($_POST['date']) ? $_POST['date'] : null;
//         $price = isset($_POST['price']) ? $_POST['price'] : null;
//         $stock = isset($_POST['stock']) ? $_POST['stock'] : null;
//         $ageLimit = isset($_POST['ageLimit']) ? $_POST['ageLimit'] : null;


        
//     }
// }



$title = "Gestion/Films";
require_once "../inc/header.inc.php";
?>

<main>
    <h2 class="text-center fw-bolder mb-5 text-danger"> <?= isset($film)? 'Modifier un film' : 'Ajouter un film'?></h2>
    <?php
    // debug($_POST);
    echo $info;

    ?>
    <form action="" method="post" enctype="multipart/form-data" class="back">
        <!-- L'attribut enctype spécifie que le formulaire envoi des fichiers en plus des données 'text' => permet de UPLOADER un fichier (photo) => Il est obligatoire--->

        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="title">Titre de film</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= $film['title'] ?? '' ?>">
            </div>
            <div class="col-md-6 mb-5">
                <label for="image">Photo</label>
                <br>
                <!-- <input type="file" name="image" id="image "> -->
                <input class="form-control fs-3" type="file" id="image" name="image" value="<?= $film['image'] ?? '' ?>">
           
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="director">Réalisateur</label>
                <input type="text" class="form-control" id="director" name="director" value="<?= $film['director'] ?? '' ?>">
            </div>
            <div class="col-md-6 mb-5">
                <label for="actors">Acteur(s)</label>
                <input type="text" class="form-control" id="actors" name="actors" value="<?= $film['actors'] ?? '' ?>"
                    placeholder="séparez les noms d'actors avec un/">
            </div>
        </div>

        <div class="row">
            <div class="mb-3">
                <label for="ageLimit" class="form-label">Age limite</label>
                <select multiple class="form-select form-select-lg fs-3" name="ageLimit" id="ageLimit">
                    <option value="10"<?php if(isset($film['ageLimit']) && $film['ageLimit'] ==10) echo 'selected' ?>>10</option>
                    <option value="13"<?php if(isset($film['ageLimit']) && $film['ageLimit'] ==13) echo 'selected' ?>>13</option>
                    <option value="16"<?php if(isset($film['ageLimit']) && $film['ageLimit'] ==16) echo 'selected' ?>>16</option>
                </select>
            </div>
        </div>

        <div class="row">
            <label for="categories">Genre du film</label>
            </div>
            <?php

                $categories = allCategories();
                // debug($categories);

                foreach($categories as $category) {

            ?>
            <!-- <div class="row"> -->
            <div class="form-check col-sm-12 col-md-4">
                    <input type="radio" name="categories" class="form-check-input" id="flexRadioDefault1" value="<?= $category['id_category'] ?>" <?php if (isset($film['category_id']) && $film['category_id'] == $category['id_category']) echo 'checked' ?>>

                    <label class="form-check-label" for="flexRadioDefault1"><?= $category['name'] ?></label>
            </div>
            <!-- </div> -->
        

        <?php
             }
        ?>

        <div class="row">
            <div class="col-md mb-5">
                <label for="duration">Durée du film</label>
                <input type="time" class="form-control" id="duration" name="duration" value="<?= $film['duration']?? ''?>">
            </div>
            <div class="col-md mb-5">
                <label for="date">Date de sortie</label>
                <input type="date" class="form-control" id="date" name="date" value="<?= $film['date']?? ''?>">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-5">
                <label for="price">Prix</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="price" name="price" aria-label="Euros amount (with dot and two decimal places)" value="<?= $film['price']?? ''?>">
                    <span class="input-group-text">€</span>
                </div>
            </div>

            <div class="col-md-6 mb-5">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" min="0" value="<?= $film['stock'] ?? '' ?>">
            </div>
        </div>

        <div class="row mb-5">
            <div class="class col-12">
                <label for="synopsis">Synopsis</label>
                <textarea class="form-control" type="text" name="synopsis" id="synopsis"  rows="10"><?= $film['synopsis']?? ''?></textarea>
            </div>
        </div>

        <div class="row justify-content-center">
            <button type="submit" class="btn btn-danger w-25 p-3 fw-bolder fs-3"><?= (isset($film)) ? 'Modifier un film' : 'Ajouter un film' ?></button>
        </div>
    </form>





</main>











<?php
require_once "../inc/footer.inc.php";
?>