<?php

namespace SAS\Requests\Models;

use Model;
use Winter\Storm\Network\Http;
use Winter\Location\Models\Setting;

/**
 * Request Model
 */
class Request extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sas_requests_requests';

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    public $appends = [
        'directions_url',
        'type_name',
    ];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = ['data'];

    /**
     * @var array Relations
     */
    public $attachOne = [
        'photo' => [\System\Models\File::class],
    ];
    public $belongsTo = [
        'type' => [
            RequestType::class,
            'key' => 'type_id',
        ],
    ];

    public function getLatitudeAttribute()
    {
        return @$this->data['location']['lat'];
    }

    public function getLongitudeAttribute()
    {
        return @$this->data['location']['lng'];
    }

    public function getTypeNameAttribute(): string
    {
        return $this->type?->name ?? 'Other';
    }

    public function getDirectionsUrlAttribute()
    {
        $lat = $this->latitude;
        $lng = $this->longitude;

        return "https://www.google.com/maps/dir/?api=1&destination=$lat,$lng";
    }

    public $address = '';
    public function beforeCreate()
    {
        $request = request();
        $this->data = array_merge($this->data, ['user_agent' => $request->header('User-Agent'), 'ip_address' => $request->ip()]);

        $lat = @$this->data['location']['lat'];
        $lng = @$this->data['location']['lng'];
        $address = '';
        $city = '';
        $province = '';

        try {
            $key = Setting::get('google_maps_key');
            $request = Http::get("https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&key=$key");
            $result = json_decode($request->body);

            if (!empty($result->results)) {
                foreach ($result->results as $result) {
                    foreach ($result->address_components as $component) {
                        if (in_array('locality', $component->types)) {
                            $city = $component->long_name;
                        }
                        if (in_array('administrative_area_level_1', $component->types)) {
                            $province = $component->long_name;
                        }

                        if (!empty($city) && !empty($province)) {
                            $address = $result->formatted_address;
                            break 2;
                        }
                    }
                }
            }
        } catch (\Exception $ex) {
            throw $ex;
        }

        $this->latitude = $lat;
        $this->longitude = $lng;
        $this->address = $address;
        $this->city = $city;
        $this->province = $province;
    }

    public function beforeValidate()
    {
        if (!$this->exists) {
            $this->rules = array_merge($this->rules, [
                'description' => 'required',
            ]);
        }
    }

    public function getCityOptions()
    {
        $options = static::lists('city');
        return array_combine($options, $options);
    }

    public function getProvinceOptions()
    {
        $options = static::lists('province');
        return array_combine($options, $options);
    }
}
