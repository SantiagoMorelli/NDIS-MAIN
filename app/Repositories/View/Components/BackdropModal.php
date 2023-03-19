<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BackdropModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $orderId;
    public function __construct($orderId)
    {
        //
        $this->orderId = $orderId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backdrop-modal');
    }
}
