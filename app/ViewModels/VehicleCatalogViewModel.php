<?php

namespace App\ViewModels;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class VehicleCatalogViewModel
{
    public function __construct(
        protected LengthAwarePaginator $vehicles,
        protected array $stats,
        protected Collection $recentActivity
    ) {
    }

    public function vehicles(): LengthAwarePaginator
    {
        return $this->vehicles;
    }

    public function stats(): array
    {
        return $this->stats;
    }

    public function recentActivity(): Collection
    {
        return $this->recentActivity;
    }
}
