<?php

require_once("modele/Manager.php");
require_once("modele/Liaison.php");
require_once("modele/PortManager.php");
require_once("modele/SecteurManager.php");

class LiaisonManager extends Manager
{

    
    public function get($id) // récupère un objet liaison en fonction de son id
    {
        $portManager = new PortManager(); // Création d'un objet manager de port
        $secteurManager = new SecteurManager(); // Création d'un objet manager de secteur

        $q = $this->getPDO()->query('SELECT * FROM liaison WHERE id = '.(int) $id);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);
        $portDepart = $portManager->get($donnees['idPortDepart']) ;
        $portArrivee = $portManager->get($donnees['idPortArrivee']) ;
        $secteur = $secteurManager->get($donnees['codeSecteur']) ;

        return new Liaison($donnees['code'], $secteur, $donnees['distance'], $portDepart, $portArrivee);
    }

    public function getList()
    {
        $portManager = new PortManager(); // Création d'un objet manager de port
        $secteurManager = new SecteurManager(); // Création d'un objet manager de secteur
        $secteurs = $secteurManager->getList(); // construction collection secteurs
        $ports = $portManager->getList(); // construction collection ports

        $liaisons = [];
        $q = $this->getPDO()->query('SELECT * FROM liaison ORDER BY codeSecteur');

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $portDepart = $ports[$donnees['idPortDepart']] ; // on va cherche l'objet port dans la collection à la clé $donnees['idPortDepart']
            $portArrivee = $ports[$donnees['idPortArrivee']] ;
            $secteur = $secteurs[$donnees['codeSecteur']] ;
            $liaisons[$donnees['code']] = new Liaison($donnees['code'], $secteur, $donnees['distance'], $portDepart, $portArrivee);
        }

        return $liaisons;
    }

    public function getListBySecteur($secteur) // on passe la référence de l'objet secteur
    {

        $portManager = new PortManager(); // Création d'un objet manager de port
        $secteurManager = new SecteurManager(); // Création d'un objet manager de secteur  
        $ports = $portManager->getList(); // construction collection ports 

        $liaisons = [];
        $q = $this->getPDO()->query('SELECT * FROM liaison WHERE codeSecteur = '.(int) $secteur->getId());

        while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
        {
            $portDepart = $ports[$donnees['idPortDepart']] ; // on va cherche l'objet port dans la collection à la clé $donnees['idPortDepart']
            $portArrivee = $ports[$donnees['idPortArrivee']] ;
            $secteur = $secteur ;
            $liaisons[$donnees['code']] = new Liaison($donnees['code'], $secteur, $donnees['distance'], $portDepart, $portArrivee);
        }

        return $liaisons;
    }

}

?>