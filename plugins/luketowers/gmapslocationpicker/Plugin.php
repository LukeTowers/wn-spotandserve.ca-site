<?php namespace LukeTowers\GMapsLocationPicker;

use Backend;
use System\Classes\PluginBase;

/**
 * GMapsLocationPicker Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'GMapsLocationPicker',
            'description' => 'No description provided yet...',
            'author'      => 'LukeTowers',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any form widgets implemented in this plugin.
     */
    public function registerFormWidgets()
    {
        return [
            'LukeTowers\GMapsLocationPicker\FormWidgets\GMapsLocationPicker' => [
                'label' => 'Location Picker',
                'code'  => 'gmaps-location-picker'
            ],
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'luketowers.gmapslocationpicker.some_permission' => [
                'tab' => 'GMapsLocationPicker',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'gmapslocationpicker' => [
                'label'       => 'GMapsLocationPicker',
                'url'         => Backend::url('luketowers/gmapslocationpicker/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['luketowers.gmapslocationpicker.*'],
                'order'       => 500,
            ],
        ];
    }
}
