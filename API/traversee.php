<?php

include_once("../modele/bd.inc.php");
$request_method = $_SERVER["REQUEST_METHOD"];





   
function getBateau($num=0)
{
    $cnx = getPDO();
    if($id != 0)
    {
        $req = $cnx->prepare("SELECT * FROM bateau WHERE num = :num");
        $req->bindValue(':num', $num, PDO::PARAM_INT);
    }
    else
    {
        $req = $cnx->prepare("SELECT * FROM traversee");
    }
    $req->execute();
    while($ligne = $req->fetch(PDO::FETCH_ASSOC))
    {
        $response[] = $ligne;
    }
    header('Content-Type: application/json');
    echo json_encode($response, JSON_PRETTY_PRINT);
}




switch($request_method)
    {
        case 'GET':
            // Récupère les bateaux
            if(!empty($_GET["$num"]))
            {
                $id=intval($_GET["num"]);
                getTraversee($num);
            }
            else
            {
                getTraversee();
            }
            break;
        
        default:
            // Invalid Request Method
            header("HTTP/1.0 405 Method Not Allowed");
            break;
 
    }
?>
