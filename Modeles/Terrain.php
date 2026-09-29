<?php
declare(strict_types=1);
require_once __DIR__ . '/Modele.php';

class Terrain extends Modele {
    public function obtenirTous(): array { 
        return $this->executer('SELECT * FROM terrain')->fetchAll(); 
    }
    
    public function obtenirParId(int $id): ?array {
        $terrain = $this->executer('SELECT * FROM terrain WHERE id = :id', ['id' => $id])->fetch();
        return $terrain ?: null;
    }
}