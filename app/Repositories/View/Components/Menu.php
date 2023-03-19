<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     *
     */
    public $orderStatus;
    public $type;
    public function __construct($orderStatus,$type)
    {
        //
        $this->orderStatus=$orderStatus;
        $this->type=$type;
        // $this->id=$id;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu');
    }
}
