<?php
  // var_dump($liaisons);
  // var_dump($liaisonsSecteur);
?>
  <h1><?= $titre ?></h1>
  <table class="table">
        <thead>
          <tr>
            <th scope="col">Secteur</th>
            <th scope="col">Code Liaison</th>
            <th scope="col">Distance en milles marin</th>
            <th scope="col">Port de départ</th>
            <th scope="col">Port d’arrivée</th>
          </tr>
        </thead>
        <tbody>
      
    <?php
    foreach ($liaisonsSecteur as $secteur){
      $i = 1; // itérateur pour différentier la première ligne
      $nbLiaisons = count($secteur);
    ?> 
          <?php
          foreach ($secteur as $liaison){
            if ($i==1){
            ?>
              <tr>
                <th scope="row" rowspan="<?= $nbLiaisons ?>">
                  <?= $liaison->getSecteur()->getNom() ?>
                </th>
            <?php } else { ?>
              <tr>
            <?php } ?>

                <td><?= $liaison->getCode(); ?></td>
                <td><?= $liaison->getDistance(); ?></td>
                <td><?= $liaison->getPortDepart()->getNom(); ?></td>
                <td><?= $liaison->getPortArrivee()->getNom(); ?></td>
              </tr>

          <?php
          $i++;
          }
          ?>

    <?php
    }
    ?>

    </tbody>
  </table>
