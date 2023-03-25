<?php namespace SAS\Requests\Components;

use Cms\Classes\ComponentBase;
use Winter\Storm\Support\Facades\Url;

class RequestMap extends ComponentBase
{
    /**
     * Gets the details for the component
     */
    public function componentDetails()
    {
        return [
            'name'        => 'RequestMap Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * Returns the properties provided by the component
     */
    public function defineProperties()
    {
        return [];
    }

    public function init()
    {
        $apiKey = \Winter\Location\Models\Setting::get('google_maps_key');
        $this->addJs('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key='.$apiKey);
        $this->addJs('https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/src/markerclusterer.js');
        $this->addJs(Url::asset('plugins/sas/requests/assets/js/requestmap.js'));
    }

    public function onGetLocations(): array
    {
        $locations = \SAS\Requests\Models\Request::where('status', 'submitted')->get();

        return ['locations' => $locations];
    }
}
