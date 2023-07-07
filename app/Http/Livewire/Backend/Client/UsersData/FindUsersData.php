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
            'fromDate' => 'required|date_format:Y-m-d',
            'toDate' => 'required_with:fromDate|date_format:Y-m-d|after_or_equal:fromDate',
        ], [
            'fromDate.required' => 'The From Date must be filled first.',
            'toDate.required_with' => 'The To Date must be filled when From Date is present.',
            'toDate.after_or_equal' => 'The To Date must be after or equal to From Date.',
        ]);

        // Check if the fromDate is later than the toDate. If so, add an error message to the 'toDate' field.
        if ($this->fromDate > $this->toDate) {
            $this->addError('toDate', 'The To Date must be after or equal to From Date.');
        } else {
            if (empty($this->fromDate)) {
                $this->addError('fromDate', 'The From Date must be filled first.');
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
}
