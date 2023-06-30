<?php

namespace App\Traits;

trait CloseModalTrait
{
    /**
     * Close the modal.
     */
    public function closeModal()
    {
        // Reset the form for the next client
        $this->resetFields();
        // Reset the validation error messages
        $this->resetErrorBag();
        $this->dispatchBrowserEvent('hide-modal');
    }
}
