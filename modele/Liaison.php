<?php

class Liaison {
    private $code;
    private $secteur; // référence vers un objet secteur
    private $distance;
    private $portDepart; // référence vers un objet port
    private $portArrivee; // référence vers un objet port
    
    public function __construct($code, $secteur, $distance, $portDepart, $portArrivee) 
    {
        $this->code = $code;
        $this->secteur = $secteur;
        $this->distance = $distance;
        $this->portDepart = $portDepart;
        $this->portArrivee = $portArrivee;
    }

    public function getCode() {
        return $this->code;
    }

    public function getSecteur() {
        return $this->secteur;
    }

    public function getDistance() {
        return $this->distance;
    }

    public function getportDepart() {
        return $this->portDepart;
    }

    public function getportArrivee() {
        return $this->portArrivee;
    }

    public function setCode($code): void {
        $this->code = $code;
    }

    public function setSecteur($secteur): void {
        $this->secteur = $secteur;
    }

    public function setDistance($distance): void {
        $this->distance = $distance;
    }

    public function setportDepart($portDepart): void {
        $this->portDepart = $portDepart;
    }

    public function setportArrivee($portArrivee): void {
        $this->portArrivee = $portArrivee;
    }

}
?>