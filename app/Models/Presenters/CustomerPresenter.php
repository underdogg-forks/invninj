<?php

namespace App\Models\Presenters;

/**
 * Class CustomerPresenter
 * @package App\Models\Presenters
 */
class CustomerPresenter extends EntityPresenter
{

    /**
     * @return string
     */
    public function name()
    {
        return $this->entity->name ?: $this->entity->primary_contact->first()->first_name . ' '. $this->entity->primary_contact->first()->last_name;
    }
}
