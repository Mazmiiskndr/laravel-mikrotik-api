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
        $this->validateDate($field);
        $this->checkDateOrder();
    }

    /**
     * Validate the date fields.
     * @param string $field The name of the updated property.
     * @return void
     */
    private function validateDate($field)
    {
        if ($field === 'fromDate') {
            // Validate the fromDate field only
            $this->validateOnly($field, [
                'fromDate' => 'required|date_format:Y-m-d',
            ], [
                'fromDate.required' => 'The From Date must be filled first.',
            ]);
        } else if ($field === 'toDate') {
            // Validate the toDate field only if fromDate is not null
            if (!empty($this->fromDate)) {
                $this->validateOnly($field, [
                    'toDate' => 'date_format:Y-m-d|after_or_equal:fromDate',
                ], [
                    'toDate.after_or_equal' => 'The To Date must be after or equal to From Date.',
                ]);
            } else {
                $this->addError('fromDate', 'The From Date must be filled first.');
            }
        }
    }

    /**
     * Check if the fromDate is later than the toDate.
     * @return void
     */
    private function checkDateOrder()
    {
        if (!empty($this->fromDate) && !empty($this->toDate) && $this->fromDate > $this->toDate) {
            $this->addError('toDate', 'The To Date must be after or equal to From Date.');
        } else if (!empty($this->fromDate) && !empty($this->toDate)) {
            $data = [
                'fromDate' => $this->fromDate,
                'toDate' => $this->toDate,
            ];
            // If the dates are valid, we emit an event called 'dateUpdated'.
            $this->emit('dateUpdated', $data);
        }
    }
}
