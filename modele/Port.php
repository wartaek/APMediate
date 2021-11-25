<?php

class Port 
{
    private $id;
    private $nom;
    
    public function __construct($id, $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNom($nom): void {
        $this->nom = $nom;
    }
    
    /*public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value)
        {
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);           
            // Si le setter correspondant existe.
            if (method_exists($this, $method))
            {
            // On appelle le setter.
            $this->$method($value);
            }
        }
    }*/

}
?>