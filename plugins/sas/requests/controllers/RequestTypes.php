<?php namespace SAS\Requests\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Request Types Backend Controller
 */
class RequestTypes extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('SAS.Requests', 'sas', 'requesttypes');
    }
}
