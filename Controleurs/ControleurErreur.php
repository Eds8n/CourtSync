<?php
declare(strict_types=1);
class ControleurErreur {
    private $vue;
    public function __construct(Vue $v) { $this->vue = $v; }
    public function afficher(string $msg, int $statut): void { http_response_code($statut); $this->vue->afficher('erreur', ['message' => $msg], 'Erreur'); }
}