<?php

namespace App\Models;

use App\Models\AbstractModel;

class MatchFormatModel extends AbstractModel
{

    public function getId(): ?int
    {
        return isset($this->attributes['id']) ? (int)$this->attributes['id'] : null;
    }

    public function getName(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    public function getParticipantsNumber(): ?int
    {
        if (isset($this->attributes['default_participant_count'])) {
            return (int)$this->attributes['default_participant_count'];
        }
        if (isset($this->attributes['participants_number'])) {
            return (int)$this->attributes['participants_number'];
        }
        return null;
    }
}
