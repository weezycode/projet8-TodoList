<?php

declare(strict_types=1);

namespace App\Service;

/**
 * @codeCoverageIgnore
 */
class MetaData
{

    public function userData()
    {
        $name = [
            ['username' => 'Alpha', 'roles' => 'ROLE_ADMIN', 'setUser' => 'user1'],
            ['username' => 'Bravo', 'roles' => 'ROLE_USER', 'setUser' => 'user2'],
            ['username' => 'Charlie', 'roles' => 'ROLE_USER', 'setUser' => 'user3'],
            ['username' => 'Delta', 'roles' => 'ROLE_USER', 'setUser' => '4'],
            ['username' => 'Echo', 'roles' => 'ROLE_USER', 'setUser' => 'user5'],
            ['username' => 'Foxe', 'roles' => 'ROLE_USER', 'setUser' => 'user6'],
            ['username' => 'Gaston', 'roles' => 'ROLE_USER', 'setUser' => 'user7'],
            ['username' => 'Hotel', 'roles' => 'ROLE_USER', 'setUser' => 'user8'],
            ['username' => 'India', 'roles' => 'ROLE_USER', 'setUser' => 'user9'],
            ['username' => 'Janvier', 'roles' => 'ROLE_ADMIN', 'setUser' => 'user10'],
            ['username' => 'Kilo', 'roles' => 'ROLE_USER', 'setUser' => 'user11'],
        ];
        return $name;
    }

    public function taskData()
    {
        $task = [
            ['title' => 'Nouveau réseau', 'content' => 'Mise en place d\'un sytème de réseau', 'is_Done' => 1, 'setUser' => 'user1'],
            ['title' => 'Achat fournitures', 'content' => 'Commande de fournitures', 'is_Done' => 0, 'setUser' => 'user2'],
            ['title' => 'Commande véhicules', 'content' => 'Commande passé au PSA', 'is_Done' => 0, 'setUser' => 'user3'],
            ['title' => 'Milestone', 'content' => 'Gestion du projet', 'is_Done' => 1, 'setUser' => 'user3'],
            ['title' => 'Publicité', 'content' => 'Mettre en place la publicité dans les réseaux sociaux', 'is_Done' => 0, 'setUser' => 'user1'],
            ['title' => 'Finir le projet8', 'content' => 'Faire de la migration', 'is_Done' => 1, 'setUser' => 'user6'],
            ['title' => 'Réunion', 'content' => 'Contacter toute l\'équipe', 'is_Done' => 1, 'setUser' => 'user5'],
        ];
        return $task;
    }
}
