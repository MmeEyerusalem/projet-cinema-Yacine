<?php
require_once "inc/functions.inc.php";

$info = "";


// if (isset($_GET) && !empty($_GET)) {
//      if (isset($_GET['id_category'])) {
//           $message = "films à vous proposer dans cette categorie";
//           $films = filmByCategoryId($_GET['id_category']);

//           if (count($films) == 0) {
//                $info = alert("Aucun film dans cette categorie", "danger");
//           }
//      } else if (isset($_GET['voirPlus'])) {
//           $films = allFilms();
//           $message = "films à vous proposer.";
//      }
// } else {
//      $films = filmByDate();
//      $message = "films récents à vous proposer.";
// }
//

if (isset($_GET) && !empty($_GET)) {

     if (isset($_GET['id_category'])) {

          $films = filmByCategoryId(($_GET['id_category']));
          $message = "films à vous proposer dans cette catégorie.";

          if (count($films) == 0) {
               $info = alert("Désolé pas de film afficher, choisissez une autre catégorie", "danger");

          }
     } else if (isset($_GET['voirPlus'])) {

          $films = allFilms();
          $message = "films a vous proposer.";

     }

} else {
     $films = filmByDate();
     $message = "films récents à vous proposer";
}

$title = "Accueil";

require_once "inc/header.inc.php";
?>



<!-- Main -->
<main class="container-fluid">


     <div class="films">
          <h2 class="fw-bolder fs-1 my-5 mx-5">

               <span class="nbreFilms">
                    <?= count($films) ?? "" ?>
               </span>
               <?= $message ?? "films" ?>
          </h2>


          <div class="row gap-4">
               <?php
               echo $info;

               foreach ($films as $film) {
                    ?>

                    <!-- <div class="clalss col-sm-12 col-md-6 col-lg-4"> -->
                    <div class="card bg-dark w-25 p-0 mx-auto">
                         <img src="<?= RACINE_SITE . "assets/" . $film['image'] ?>" alt="Affiche du film">
                         <div class="card-body">
                              <h3>
                                   <?= $film['title'] ?>
                              </h3>
                              <h4>
                                   <?= $film['director'] ?>
                              </h4>
                              <p>
                                   <span class="fw-bolder">Résumé</span>
                                   <?= substr(html_entity_decode($film['synopsis']), 0, 100) . "...." ?>
                              </p>

                              <a href="<?= RACINE_SITE . "showFilm.php?id_film=" . $film['id_film'] ?>" class="btn">Plus
                                   de
                                   details</a>

                         </div>

                    </div>

                    <!-- </div> -->

                    <?php
               }
               if (empty($_GET)) {
                    ?>

                    <div class="col-12 text-center">
                         <a href="<?= RACINE_SITE ?>index.php?voirPlus" class="btn  p-4 fs-3">Voir Plus</a>
                    </div>

                    <?php

               }

               ?>
          </div>

     </div>





     </div>



</main>



<?php
require_once "inc/footer.inc.php";


?>