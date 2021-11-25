<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}

require_once("$racine/modele/LiaisonManager.php");
$liaisonManager = new LiaisonManager(); // Création d'un objet
$secteurManager = new secteurManager(); // Création d'un objet

// $liaisons = $liaisonManager->getList();

if (isset($_GET['id'])){
    $idSecteur = $_GET['id'];
    $secteur = $secteurManager->get($idSecteur); // Appel d'une fonction de cet objet
    $liaisonsSecteur[] = $liaisonManager->getListBySecteur($secteur); // Appel d'une fonction de cet objet
    $titre = "Liaisons du secteur ". $secteur->getNom();

} else {
    $titre = "Liaisons par secteur";
    $secteurs = $secteurManager->getList(); // Appel d'une fonction de cet objet
    foreach ($secteurs as $secteur){
        $liaisonsSecteur[$secteur->getId()] = $liaisonManager->getListBySecteur($secteur); // Appel d'une fonction de cet objet
    }
}

// appel du script de vue qui permet de gerer l'affichage des donnees
include "$racine/vue/header.php";
include "$racine/vue/vueAfficheLiaisons.php";
include "$racine/vue/footer.php";
?>

