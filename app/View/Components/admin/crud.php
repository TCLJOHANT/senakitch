<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class crud extends Component
{
    public $items;
    public $titleModal;
    public $modelName;
    public $fields;
    public $editItem ;

    public function __construct($items,$titleModal,$modelName,$fields)
    {
        $this->items = $items;
        $this->titleModal = $titleModal;
        $this->modelName = $modelName;
        $this->fields = $fields;
        $this->editItem = null; // Inicializar $editItem como null
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.crud');
    }
    public function editItemData(Request $request){
        $this->editItem = $request->all();
    }

}
