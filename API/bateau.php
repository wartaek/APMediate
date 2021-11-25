<?php
    include_once("../modele/bd.inc.php");
    $request_method = $_SERVER["REQUEST_METHOD"];



     
    function getBateaux()
{
    $cnx = getPDO();
    $req = $cnx->prepare("SELECT * FROM bateau");
    $req->execute();
 
    while($ligne = $req->fetch(PDO::FETCH_ASSOC))
    {
        $response[] = $ligne;
    }
    header('Content-Type : application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}
 
function getBateau($id=0)
{
    $cnx = getPDO();
    if($id != 0)
    {
        $req = $cnx->prepare("SELECT * FROM bateau WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
    }
    else
    {
        $req = $cnx->prepare("SELECT * FROM bateau");
    }
    $req->execute();
    while($ligne = $req->fetch(PDO::FETCH_ASSOC))
    {
        $response[] = $ligne;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}
 
 
function AddBateau()
{
    $cnx = getPDO();
    $req = $cnx->prepare("INSERT INTO bateau (id, nom, photo) VALUES (:id, :nom, :photo)");
    $req->bindParam(':id', $_POST["id"]);
    $req->bindParam(':nom', $_POST["nom"]);
    $req->bindParam(':photo', $_POST["photo"]);

    if ($req->execute())
    {
        $response=array(
            'status' => 1,
            'status_message' =>'Bateau ajouté avec succès.'
        );
    }
    else
    {
        $response=array(
            'status' => 0,
            'status_message' =>'ERREUR!.'. $cnx->errorInfo()
         );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
    
    function updateBateau($id)
    {
        $cnx = getPDO();
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        $req = $cnx->prepare("UPDATE bateau SET nom = :nom,  photo = :photo WHERE id = :id");
        $req->bindValue(':nom', $_PUT["nom"], PDO::PARAM_STR);
        $req->bindValue(':photo', $_PUT["photo"], PDO::PARAM_STR);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
 
        if($req->execute())
        {
            $response=array(
                'status' => 1,
                'status_message' => 'Bateau mis à jour avec succès.'
            );
        }
        else
        {
            $response=array(
                'status' =>0,
                'status_message' => 'Echec de la mise à jour de bateau. '. $cnx->errorInfo()
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }


    function deleteBateau($id) {
        
        $cnx = getPDO();
        $req = $cnx->prepare(" DELETE FROM bateau WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        if($req->execute())
        {
            $response=array(
                'status' => 1,
                'status_message' => 'La supression du bateau à échoué.'. $cnx->errorInfo());
            }
            header('Content-Type: application/json');
            echo json_encode($reponse);
            
        }
    
    


 
    switch($request_method)
    {
        case 'GET':
            // Récupère les bateaux
            if(!empty($_GET["id"]))
            {
                $id=intval($_GET["id"]);
                getBateau($id);
            }
            else
            {
                getBateaux();
            }
            break;
        
        case 'POST':
            //Ajouter un bateau
            AddBateau();
            break;
        case 'PUT' : 
            //Modifier un bateau
            $id = intval($_GET["id"]);
            updateBateau($id);
            break;
        case 'DELETE' :
            //Supprime un bateau
            $id = intval($_GET["id"]);
            deleteBateau($id);
            break;
        
        
        default:
            // Invalid Request Method
            header("HTTP/1.0 405 Method Not Allowed");
            break;
 
    }
?>