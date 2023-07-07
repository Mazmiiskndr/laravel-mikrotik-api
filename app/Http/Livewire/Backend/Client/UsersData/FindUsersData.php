<?php

namespace App\Http\Livewire\Backend\Client\UsersData;

use Livewire\Component;

class FindUsersData extends Component
{
    public $fromDate, $toDate;

    /**
     * Render the component `form find-users-data`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.client.users-data.find-users-data');
    }

    /**
     * Method that is called whenever a model's property is updated.
     * @param string $field The name of the updated property.
     * @return void
     */
    public function updated($field)
    {
        // Here we validate the input for fromDate and toDate fields.
        $this->validateOnly($field, [
            'fromDate' => 'date_format:Y-m-d|nullable',
            'toDate' => 'date_format:Y-m-d|nullable',
        ]);

        // Check if the fromDate is later than the toDate. If so, add an error message to the 'toDate' field.
        if ($this->fromDate > $this->toDate) {
            $this->addError('toDate', 'The To Date must be after From Date.');
        } else {
            $data = [
                'fromDate' => $this->fromDate,
                'toDate' => $this->toDate,
            ];
            // If the dates are valid, we emit an event called 'dateUpdated'.
            $this->emit('dateUpdated', $data);
        }

    }

}
