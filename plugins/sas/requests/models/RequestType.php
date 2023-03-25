<?php namespace SAS\Requests\Models;

use Model;

/**
 * RequestType Model
 */
class RequestType extends Model
{
    use \Winter\Storm\Database\Traits\Sluggable;
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sas_requests_request_types';

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @var array Generate slugs for these attributes.
     */
    protected $slugs = ['slug' => 'name'];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [
        'name' => 'required',
        'slug' => 'required|slug|unique',
    ];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'data',
    ];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'requests' => [
            Request::class,
            'key' => 'type_id',
        ],
    ];
}
