<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}

require_once("$racine/modele/PortManager.php");
    
$titre = "Liste des ports";

$portManager = new PortManager(); // Création d'un objet
$ports = $portManager->getList(); // Appel d'une fonction de cet objet


// appel du script de vue qui permet de gerer l'affichage des donnees
include "$racine/vue/header.php";
include "$racine/vue/vueAffichePorts.php";
include "$racine/vue/footer.php";
?>

