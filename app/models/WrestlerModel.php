<?php

namespace App\Models;

use App\Models\AbstractModel;

class WrestlerModel extends AbstractModel
{
    // Optionnel : tu peux déclarer la table ici si tu veux forcer
    protected string $table = "wrestlers";

    // Pas besoin de propriétés typées ici
    // Le tableau $attributes de AbstractModel contient déjà les données

    // Getters simples, qui lisent dans $attributes
    public function getId(): ?int
    {
        return isset($this->attributes['id']) ? (int)$this->attributes['id'] : null;
    }

    public function getName(): ?string
    {
        return $this->attributes['name'] ?? null;
    }
}