<?php
declare(strict_types=1);
require_once __DIR__ . '/Modele.php';
class MatchModele extends Modele {
    public function obtenirParTerrain(int $terrainId): array { 
        return $this->executer('SELECT * FROM matchs WHERE terrain_id = :tid ORDER BY date_heure ASC', ['tid' => $terrainId])->fetchAll(); 
    }
    public function obtenirParId(int $id): ?array { 
        $m = $this->executer('SELECT * FROM matchs WHERE id = :id', ['id' => $id])->fetch(); 
        return $m ?: null; 
    }
    public function ajouter(string $date, int $tId, int $uId): void { 
        $this->executer('INSERT INTO matchs (date_heure, terrain_id, utilisateur_id) VALUES (:d, :t, :u)', ['d'=>$date, 't'=>$tId, 'u'=>$uId]); 
    }
    public function supprimer(int $id): void { 
        $this->executer('DELETE FROM matchs WHERE id = :id', ['id' => $id]); 
    }
    public function modifier(int $id, string $date): void { 
        $this->executer('UPDATE matchs SET date_heure = :d WHERE id = :id', ['d' => $date, 'id' => $id]); 
    }
}