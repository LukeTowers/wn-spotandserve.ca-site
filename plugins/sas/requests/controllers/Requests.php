<?php namespace SAS\Requests\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Requests Backend Controller
 */
class Requests extends Controller
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

        BackendMenu::setContext('SAS.Requests', 'sas', 'requests');
    }

    public function runAjaxHandler($handler)
    {
        if (is_null($this->params)) {
            $this->params = [];
        }

        return parent::runAjaxHandler($handler);
    }
}
