<?php
require_once "../inc/functions.inc.php";

if(!isset($_SESSION['user'])) {

    header("location:".RACINE_SITE."authentification.php");
    
}else{
    if($_SESSION['user']['role'] == 'ROLE_USER'){

        header("location:".RACINE_SITE."index.php");
    }
}
// debug($_SESSION['User']);


// if (isset($_GET['action']) && isset($_GET['id_user'])) {

//     if (!empty($_GET['action']) && $_GET['action'] == 'delete' && !empty($_GET['id_user'])) {
//         // debug($_GET['action']);

//         $idUser = htmlentities($_GET['id_user']);

//         deleteUser($idUser);
//     }

//     if (!empty($_GET['action']) && $_GET['action'] == 'update' && !empty($_GET['id_user'])) {
//         // debug($_GET['action']);
//         $user = showUser($_GET['id_user']);
//         if ($user['role'] == 'ROLE_ADMIN') {

//             updateRole('ROLE_USER', $user['id_user']);
//         }
//         if ($user['role'] == 'ROLE_USER') {

//             updateRole('ROLE_ADMIN', $user['id_user']);
//         }
//     }
// }

$title = "Backoffice";
require_once "../inc/header.inc.php";
// $info = '';


// if (empty($_SESSION['user'])){
//     header("location:".RACINE_SITE."authentification.php");
// }else{
//     if($_SESSION['user']['role']=='ROLE_USER'){
//         header("location:".RACINE_SITE."index.php");
//     }
// }

?>

<main>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-lg-2">
            <div class="d-flex flex-column text-bg-dark p-3 siderbare">
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">

                    <li><a href="?dashboard_php" class="nav-link text-light">Backoffice</a></li>
                    <li><a href="?films_php" class="nav-link text-light">Films</a></li>
                    <li><a href="?categories_php" class="nav-link text-light">Catégories</a></li>
                    <li><a href="?users_php" class="nav-link text-light">Utilisateurs</a></li>

                </ul>
                </hr>
            </div>

        </div>

        <?php
        if (isset($_GET['dashboard_php'])):
            ?>

            <div class="w-50 m-auto">
                <!-- <h2>Bonjour Eyerus</h2> -->
                <h2>Bonjour <?= $_SESSION['user']['firstName'] ?> </h2>
                <p>Bienvenue sur le backoffice</p>
                <img src="<?= RACINE_SITE ?>assets/img/affiche.jpg" alt="Affiche des films sur le backoffice" width="500"
                    height="800">
            </div>

        <?php endif; ?>

        <div class="col-sm-12">
           <!-- $_GET représente les données qui transitent par l'URL. Il s'agit d'une superglobal, et comme toutes les
            superglobales, c'est un tableau (array)
            *"superglobal" signifie que cette variable est disponible partout dans le script, y compris au sein des
            fonctions (pas besoin de faire global $_GET)
            *Les informations transitent dans l'URL selon la systaxe suivante:
            *exp : page.php?indice1=valeur1&indice2=valeur2&indiceN=valeurN
            *Quand on receptionnes les donées, $_GET est remplit selon le schéma suivant:

            *$_GET =array(
            'indice1' => 'valeur1',
            'indice2' => 'valeur2',
            'indiceN' => 'valeurN',
            )
            -->

            <?php
            if (!empty($_GET)) { // si ma variable $_GET n'est pas vide cela veut dire j'ai cliquer sur un lien de ma sidebarre, l'index de la variable $_GET change selon le lien indiqué dans la balise"a"//
                if (isset($_GET['films_php'])) {
                    require_once "films.php";

                } else if (isset($_GET['categories_php'])) {
                    require_once "categories.php";

                } else if (isset($_GET['users_php'])) {
                    require_once "users.php";

                } else {
                    require_once "dashboard.php";
                }
            }

            ?>
            
        </div>

    </div>
</main>



<?php

require_once "../inc/footer.inc.php";
?>