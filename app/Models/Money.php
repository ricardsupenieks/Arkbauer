<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Money extends Model implements MoneyInterface
{
    use HasFactory;

    private int $cents;

    public function setCents(int $cents): MoneyInterface
    {
        $this->cents = $cents;
        return $this;
    }

    public function getCents(): int
    {
        return $this->cents;
    }

    public function setEuros(int $euros): MoneyInterface
    {
        $this->cents = $euros * 100;
        return $this;
    }

    public function getEuros(): int
    {
        return $this->cents / 100;
    }
}
