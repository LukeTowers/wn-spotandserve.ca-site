<?php namespace LukeTowers\GMapsLocationPicker\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Winter\Location\Models\Setting;

/**
 * GMapsLocationPicker Form Widget
 */
class GMapsLocationPicker extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'gmaps_location_picker';

    /**
     * @var string Latitude to display in previewMode or to start the pin with in edit mode
     */
    public $lat;

    /**
     * @var string Longitude to display in previewMode or to start the pin with in edit mode
     */
    public $lng;

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'lat',
            'lng',
        ]);

        if (preg_match('/^[A-Za-z]/', $this->lat)) {
            $this->lat = $this->model->{$this->lat};
        }

        if (preg_match('/^[A-Za-z]/', $this->lng)) {
            $this->lng = $this->model->{$this->lng};
        }

        if (!$this->lat) {
            $this->lat = @$this->getLoadValue()['lat'];
        }

        if (!$this->lng) {
            $this->lng = @$this->getLoadValue()['lng'];
        }

        // dd($this->lat, $this->lng);

        if ($this->formField->disabled) {
            $this->previewMode = true;
        }
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('gmapslocationpicker');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();


        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $apiKey = Setting::get('google_maps_key');
        $this->addJs('//maps.googleapis.com/maps/api/js?libraries=places&key='.$apiKey);
        $this->addJs('https://unpkg.com/location-picker/dist/location-picker.min.js');

        $this->addCss('css/gmapslocationpicker.css', 'LukeTowers.GMapsLocationPicker');
        $this->addJs('js/gmapslocationpicker.js', 'LukeTowers.GMapsLocationPicker');
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
