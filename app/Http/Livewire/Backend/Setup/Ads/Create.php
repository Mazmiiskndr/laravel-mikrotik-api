<?php

namespace App\Http\Livewire\Backend\Setup\Ads;

use App\Models\AdType;
use App\Services\Config\Ads\AdsService;
use App\Traits\LivewireMessageEvents;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    // File Uploads for the Ads property
    use WithFileUploads;
    // LivewireMessageEvents for showing messages
    use LivewireMessageEvents;
    // Properties for inserting a new ad
    public $type, $deviceType, $imageBanner, $title, $urlForImage = "http://", $position, $timeToShow, $timeToHide, $shortDescription;
    // Ads Type
    public $adsType;
    // FOR ALERT MESSAGE
    public $adsMaxWidth, $adsMaxHeight, $adsMaxSize, $mobileAdsMaxWidth, $mobileAdsMaxHeight, $mobileAdsMaxSize, $alert;

    // Listeners
    protected $listeners = [
        'adCreated' => '$refresh',
    ];

    // Validation Rules for the Ads property
    protected $rules = [
        // REQUIRED
        'type'              => 'required',
        'imageBanner'       => 'required|image|mimes:jpg,jpeg,png,gif',
        'title'             => 'required|max:150',
        'deviceType'        => 'required',
        // NULLABLE
        'urlForImage'       => 'max:150',
        'position'          => 'nullable',
        'timeToShow'        => 'nullable|date',
        'timeToHide'        => 'nullable|date',
        'shortDescription'  => 'nullable',
    ];

    // Validation Messages for the Ads property
    protected $messages = [
        'type.required'         => 'Type cannot be empty!',
        'imageBanner.required'  => 'The Image Banner field is required.',
        'imageBanner.image'     => 'The Image Banner must be an image.',
        'imageBanner.mimes'     => 'The Image Banner must be a file of type: jpg, jpeg, png, gif.',
        'timeToShow.date'       => 'The time to show field must be a valid date.',
        'title.required'        => 'Title cannot be empty!',
        'deviceType.required'   => 'Device Type cannot be empty!',
        'title.max'             => 'Title cannot be more than 150 characters!',
        'urlForImage.max'       => 'Title cannot be more than 150 characters!',
        'timeToHide.date'       => 'The time to hide field must be a valid date.',
    ];

    /**
     * Initializes the component state.
     * Fetches the ad size from the AdsService and retrieves all ad types ordered by their creation date.
     * @param AdsService $adsService Service class for handling actions related to Ads.
     * @return void
     */
    public function mount(AdsService $adsService)
    {
        $this->getSizeAds($adsService);
        // Fetch all groups ordered by creation date
        $this->adsType = AdType::latest()->get();
    }

    /**
     * Event handler for property updates.
     * @param string $property Property that was updated
     */
    public function updated($property)
    {
        // Validate the updated property
        $this->validateOnly($property);
        // If type or deviceType has changed, dispatch an event to show an alert.
        if ($property === 'type' || $property === 'deviceType') {
            $this->alert = [
                'type' => 'primary',
                'message' => $this->getMessageAlert(),
            ];
        }
    }

    /**
     * Render the component `create`.
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.backend.setup.ads.create');
    }

    /**
     * Store a new ad.
     * @param AdsService $adsService Ad service instance
     */
    public function storeNewAd(AdsService $adsService)
    {
        // Validate form fields
        $this->validate();

        // List of properties to include in the new ad
        $properties = ['type', 'deviceType', 'imageBanner', 'title', 'urlForImage', 'position', 'timeToShow', 'timeToHide', 'shortDescription'];

        // Collect property values into an associative array
        $newAd = array_reduce($properties, function ($carry, $property) {
            $carry[$property] = $this->$property;
            return $carry;
        }, []);

        try {
            // Attempt to create the new ad
            $ad = $adsService->storeNewAd($newAd);

            // Check if the ad was created successfully
            if ($ad === null) {
                throw new \Exception('Failed to create the ad');
            }

            // Notify the frontend of success
            $this->dispatchSuccessEvent('Ad was created successfully.');

            // Let other components know that an ad was created
            $this->emit('adCreated', true);
        } catch (\Throwable $th) {
            // Notify the frontend of the error
            $this->dispatchErrorEvent($th->getMessage());
        } finally {

            // Reset the form for the next ad
            $this->resetFields();
            // Ensure the modal is closed
            $this->closeModal();
        }
    }

    /**
     * Close the modal.
     */
    public function closeModal()
    {
        // Reset the form for the next client
        $this->resetFields();
        $this->dispatchBrowserEvent('hide-modal');
    }

    /**
     * resetFields the form fields.
     * @return void
     */
    public function resetFields()
    {
        $this->type             = null;
        $this->deviceType       = null;
        $this->imageBanner      = null;
        $this->title            = null;
        $this->urlForImage      = null;
        $this->position         = null;
        $this->timeToShow       = null;
        $this->timeToHide       = null;
        $this->shortDescription = null;
    }

    /**
     * Set the size properties for ads based on the provided AdsService.
     * @param AdsService $adsService The AdsService instance to retrieve the size values from.
     * @return void
     */
    private function getSizeAds(AdsService $adsService)
    {
        $this->adsMaxWidth = $adsService->adsMaxWidth();
        $this->adsMaxHeight = $adsService->adsMaxHeight();
        $this->adsMaxSize = $adsService->adsMaxSize();
        $this->mobileAdsMaxWidth = $adsService->mobileAdsMaxWidth();
        $this->mobileAdsMaxHeight = $adsService->mobileAdsMaxHeight();
        $this->mobileAdsMaxSize = $adsService->mobileAdsMaxSize();
    }

    /**
     * Generate the message for the alert.
     * @return string The message containing the upload limitations for desktop and mobile.
     */
    private function getMessageAlert()
    {
        return '<p>You can upload as many images as you want with the following limitations : <br>' .
            '1. Desktop Max Image Width : ' . $this->adsMaxWidth . 'px, Max Image Height : ' . $this->adsMaxHeight . "px, Max Image Size : " . $this->adsMaxSize . 'kb, per file <br>' .
            '2. Mobile Max Image Width : ' . $this->mobileAdsMaxWidth . 'px, Max Image Height : ' . $this->mobileAdsMaxHeight . "px, Max Image Size: " . $this->mobileAdsMaxSize . 'kb, per file </p>';
    }
}
