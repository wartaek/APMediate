<?php
  //var_dump($bateaux);
?>
  <h1><?= $titre ?></h1>

  <?php
  foreach ($bateaux as $bateau){
  ?> 
      <div class="card" style="width: 18rem;">
        <img class="card-img-top" src="<?= $bateau['photo'] ?>" alt="Card image cap"  height="100px">
        <div class="card-body">
          <h5 class="card-title"><?= $bateau['nom'] ?></h5>
          <p class="card-text">
            <ul>
            <?php
            foreach ($bateau['capacites'] as $capacite){
            ?> 
               <li><?= $capacite['libelle'] ?> : <?= $capacite['capaciteMax'] ?></li> 
            
            <?php
            }
            ?>
            </ul>
            Liaisons assurées :
            <ul>
            <?php
            foreach ($bateau['liaisons'] as $liaison){
            ?> 
               <li><?= $liaison['portDepart'] ?> : <?= $liaison['portArrivee'] ?></li> 
            
            <?php
            }
            ?>
            </ul>

          </p>
        </div>
      </div>

  <?php
  }
  ?>
