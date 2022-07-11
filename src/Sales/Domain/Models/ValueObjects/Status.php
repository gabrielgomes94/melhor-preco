<?php

namespace Src\Sales\Domain\Models\ValueObjects;

class Status
{
    public array $statuses = [
        'Em aberto',
        'Atendido',
        'Cancelado',
        'Em andamento',
        'Venda Agenciada',
        'Em digitação',
        'Verificado'
    ];

    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function isValid(): bool
    {
        return in_array($this->status, $this->statuses, true);
    }

    public function __toString(): string
    {
        return $this->status;
    }
}
