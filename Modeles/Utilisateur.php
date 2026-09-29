<?php
declare(strict_types=1);
require_once __DIR__ . '/Modele.php';
class Utilisateur extends Modele {
    public function trouverParCourriel(string $courriel): ?array {
        $u = $this->executer('SELECT * FROM utilisateurs WHERE courriel = :c', ['c' => $courriel])->fetch(); 
        return $u ?: null;
    }
    public function ajouter(string $nom, string $courriel, string $motDePasse): void {
        $this->executer('INSERT INTO utilisateurs (nom, courriel, mot_de_passe) VALUES (:n, :c, :m)', ['n'=>$nom, 'c'=>$courriel, 'm'=>$motDePasse]);
    }
}