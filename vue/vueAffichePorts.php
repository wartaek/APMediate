<?php
  // var_dump($ports);
?>
  <h1><?= $titre ?></h1>
  <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">nom</th>
          </tr>
        </thead>
        <tbody>
      
    <?php
    foreach ($ports as $port){
    ?> 
      <tr>
        <td><?= $port->getId() ?></td>
        <td><?= $port->getNom() ?></td>
      </tr>
    <?php
    }
    ?>

    </tbody>
  </table>