<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.liaison.inc.php";


$titre = "Liste des bateaux";
$bateaux = getBateaux();


// appel du script de vue qui permet de gerer l'affichage des donnees
include "$racine/vue/header.php";
include "$racine/vue/vueAfficheBateaux.php";
include "$racine/vue/footer.php";
?>

