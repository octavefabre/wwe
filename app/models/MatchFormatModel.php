<?php

namespace App\Models;

// On utilise le modèle abstrait comme base (connexion à la BDD, logique commune)
use App\Models\AbstractModel;

class MatchFormatModel extends AbstractModel
{
    /**
     * Récupère l'ID du format de match.
     *
     * @return int|null L'ID si présent, sinon null
     */
    public function getId(): ?int
    {
        // Si l'attribut 'id' existe, on le retourne converti en entier, sinon null
        return isset($this->attributes['id']) ? (int)$this->attributes['id'] : null;
    }

    /**
     * Récupère le nom du format de match.
     *
     * @return string|null Le nom s’il existe, sinon null
     */
    public function getName(): ?string
    {
        // Retourne le nom s'il est présent, sinon null
        return $this->attributes['name'] ?? null;
    }

    /**
     * Récupère le nombre de participants par défaut pour ce format.
     *
     * @return int|null Le nombre s’il est défini, sinon null
     */
    public function getParticipantsNumber(): ?int
    {
        // Si 'default_participant_count' est défini, on le retourne
        if (isset($this->attributes['default_participant_count'])) {
            return (int)$this->attributes['default_participant_count'];
        }

        // Sinon, si un autre champ 'participants_number' est défini, on le retourne
        if (isset($this->attributes['participants_number'])) {
            return (int)$this->attributes['participants_number'];
        }

        // Sinon, on retourne null
        return null;
    }
}