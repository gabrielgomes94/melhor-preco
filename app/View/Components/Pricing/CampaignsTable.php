<?php

namespace App\View\Components\Pricing;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class CampaignsTable extends Component
{
    /**
     * @var array
     */
    public $campaigns;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $campaigns)
    {
        $this->campaigns = $campaigns;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.pricing.campaigns-table');
    }
}
