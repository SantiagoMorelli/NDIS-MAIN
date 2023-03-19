<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CreateTicketModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $orderNum;
    public function __construct($orderId=null)
    {
        //
        $this->orderNum=$orderId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.create-ticket-modal');
    }
}
