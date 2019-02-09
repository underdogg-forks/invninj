<?php

namespace Modules\Notes\Http\ViewComposers;

use App\Utils\Traits\UserSessionAttributes;
use Illuminate\View\View;

class CustomerEditComposer
{
    use UserSessionAttributes;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $data = $view->getData();
        
        $view->with('notes::edit', $this->customerEditData);
    }

    private function customerEditData()
    {

    }