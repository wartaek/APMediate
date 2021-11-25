<?php

include_once "bd.inc.php";

    function getBateaux(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM bateau");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[$ligne['id']]['nom'] = $ligne['nom'];
                $resultat[$ligne['id']]['photo'] = $ligne['photo'];
                $resultat[$ligne['id']]['capacites'] = getCapacitesByBateau($ligne['id']);
                $resultat[$ligne['id']]['liaisons'] = getLiaisonsByBateau($ligne['id']);
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getCapacitesByBateau($idBateau){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT libelle, capaciteMax FROM contenance_bateau co JOIN categorie ca ON co.lettreCategorie = ca.lettre WHERE idBateau = :id");
            $req->bindValue(':id', $idBateau, PDO::PARAM_INT);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getLiaisonsByBateau($idBateau){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT DISTINCT PD.nom as portDepart, PA.nom as portArrivee FROM liaison L 
            JOIN port PD on PD.id=L.idPortDepart 
            JOIN port PA on PA.id=L.idPortArrivee
            JOIN traversee T on T.codeLiaison = L.code
            where T.idBateau =:id");
            $req->bindValue(':id', $idBateau, PDO::PARAM_INT);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getSecteurs(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM secteur");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getSecteurById($id) {

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM secteur WHERE id=:id");
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPorts(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM port");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPortById($id) {

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT nom FROM port WHERE id=:id");
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


    function getLiaisons(){
        //$resultat = array();
        try {
            $secteurs = getSecteurs();
            foreach ($secteurs as $secteur) {
                $resultat[$secteur['id']]['nom'] = $secteur['nom'];
                $resultat[$secteur['id']]['liaisons'] = array();
                $resultat[$secteur['id']]['liaisons'] = getLiaisonsBySecteurLignes($secteur['id']);
            }
            
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getLiaisonsBySecteur($idSecteur){
        //$resultat = array();
        try {
            $resultat[$idSecteur]['nom'] = getSecteurById($idSecteur)['nom'];
            $resultat[$idSecteur]['liaisons'] = getLiaisonsBySecteurLignes($idSecteur);

        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


    function getLiaisonsBySecteurLignes($idSecteur){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT L.code, L.distance, PD.nom as portDepart, PA.nom as portArrivee FROM liaison L 
            JOIN port PD on PD.id=L.idPortDepart 
            JOIN port PA on PA.id=L.idPortArrivee
            where L.codeSecteur=:idSecteur");
            $req->bindValue(':idSecteur', $idSecteur, PDO::PARAM_INT);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getLiaisonsLignes(){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT L.code, L.codeSecteur, L.distance, PD.nom as portDepart, PA.nom as portArrivee FROM liaison L 
            JOIN port PD on PD.id=L.idPortDepart 
            JOIN port PA on PA.id=L.idPortArrivee");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getLiaisonById($id) {
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT L.code, S.nom, L.distance, PD.nom as portDepart, PA.nom as portArrivee FROM liaison L INNER JOIN secteur S on L.codeSecteur=S.id
            JOIN port PD on PD.id=L.idPortDepart 
            JOIN port PA on PA.id=L.idPortArrivee where L.code=:id");
            $req->bindValue(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $resultat = $req->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


    function getTarifsbyLiaison($idLiaison){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM tarification where codeLiaison=:idLiaison");
            $req->bindValue(':idLiaison', $idLiaison, PDO::PARAM_INT);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[$ligne['lettreCategorie']][$ligne['numType']][$ligne['dateDeb']] = $ligne['tarif'];
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getTarifs(){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM tarification");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[$ligne['codeLiaison']][$ligne['lettreCategorie']][$ligne['numType']][$ligne['dateDeb']] = $ligne['tarif'];
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPeriodes(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM periode");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getCategories(){
        $resultat = array();

        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM categorie");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getCategoriesTypes(){
        //$resultat = array();

        try {
            $categories = getCategories();
            foreach ($categories as $categorie){
                $resultat[$categorie['lettre']]['lettre'] =  $categorie['lettre'];
                $resultat[$categorie['lettre']]['libelle'] =  $categorie['libelle'];
                $cnx = getPDO();
                $req = $cnx->prepare("SELECT * FROM type WHERE lettreCategorie=:idCategorie");
                $req->bindValue(':idCategorie', $categorie['lettre'], PDO::PARAM_STR);
                $req->execute();

                $ligne = $req->fetch(PDO::FETCH_ASSOC);
                while ($ligne) {
                    $resultat[$categorie['lettre']]['types'][]= $ligne;
                    $ligne = $req->fetch(PDO::FETCH_ASSOC);
                }
            }
            
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getTraverseesByLiaisonAndDate($idLiaison, $date){
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT * FROM traversee T JOIN bateau B ON B.id=T.idBateau
            where codeLiaison=:idLiaison
            AND date=:date
            ORDER BY heure");
            $req->bindValue(':idLiaison', $idLiaison, PDO::PARAM_INT);
            $req->bindValue(':date', $date, PDO::PARAM_STR);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $resultat[] = $ligne;
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPlacesTraverseesByLiaisonAndDate($idLiaison, $date){
        // pour chaque traversée, pour chaque categorie on compte le nb de place totales dans de ce bateau dans contenance_bateau 
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT num, idBateau FROM traversee T where codeLiaison=:idLiaison
            AND date=:date");
            $req->bindValue(':idLiaison', $idLiaison, PDO::PARAM_INT);
            $req->bindValue(':date', $date, PDO::PARAM_STR);
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                $req2 = $cnx->prepare("SELECT * FROM contenance_bateau where idBateau=:id");
                $req2->bindValue(':id', $ligne['idBateau'], PDO::PARAM_INT);
                $req2->execute();              
                $ligne2 = $req2->fetch(PDO::FETCH_ASSOC);
                while ($ligne2) {

                    $resultat[$ligne['num']][$ligne2['lettreCategorie']] = intval($ligne2['capaciteMax']);                   
                    $ligne2 = $req2->fetch(PDO::FETCH_ASSOC);
                }
                $ligne = $req->fetch(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPlacesReservesTraversees(){
        // pour chaque traversée/categorie aller compter : nb de place reservées dans detail_reservation
        $resultat = array();
        try {
            $cnx = getPDO();
            $req = $cnx->prepare("SELECT r.numTraversee, d.lettreCategorie, sum(d.quantité) as 'placesReservees' FROM reservation r JOIN detail_reservation d ON d.numReservation = r.num GROUP BY r.numTraversee, d.lettreCategorie");
            $req->execute();

            $ligne = $req->fetch(PDO::FETCH_ASSOC);
            while ($ligne) {
                    $resultat[$ligne['numTraversee']][$ligne['lettreCategorie']] = intval($ligne['placesReservees']);                   
                    $ligne = $req->fetch(PDO::FETCH_ASSOC);
                }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }

    function getPlacesDispoTraverseesByLiaisonAndDate($idLiaison, $date){

        // pour chaque traversée/categorie aller compter : nb de place reservées dans detail_reservation
        $resultat = array();
        try {
            // TODO
        
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage();
            die();
        }
        return $resultat;
    }


if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog principal de test
    header('Content-Type:text/plain');

    echo "getLiaisons() : \n";
    print_r(getLiaisons());

    echo "getLiaisonsBySecteur(3) \n";
    print_r(getLiaisonsBySecteur(3));

}
?>