<?php namespace SAS\Requests;

use Backend;
use Backend\Models\UserRole;
use System\Classes\PluginBase;

/**
 * Requests Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     */
    public function pluginDetails(): array
    {
        return [
            'name'        => 'sas.requests::lang.plugin.name',
            'description' => 'sas.requests::lang.plugin.description',
            'author'      => 'SAS',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     */
    public function register(): void
    {

    }

    /**
     * Boot method, called right before the request route.
     */
    public function boot(): void
    {

    }

     /**
     * Registers any frontend components implemented in this plugin.
     */
    public function registerComponents(): array
    {
        return [
            \SAS\Requests\Components\SubmitRequest::class => 'submitRequest',
        ];
    }

    /**
     * Registers any Winter.Pages Snippets
     */
    public function registerPageSnippets()
    {
        return $this->registerComponents();
    }

    /**
     * Registers any backend permissions used by this plugin.
     */
    public function registerPermissions(): array
    {
        return [
            'sas.requests.manage_requests' => [
                'tab' => 'Spot & Serve',
                'label' => 'Manage requests'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     */
    public function registerNavigation(): array
    {
        return [
            'sas' => [
                'label'       => 'Spot & Serve',
                'url'         => Backend::url('sas/requests/requests'),
                'icon'        => 'icon-flag',
                'permissions' => ['sas.requests.*'],
                'order'       => 100,
                'sideMenu' => [
                    'requests' => [
                        'label'       => 'Requests',
                        'url'         => Backend::url('sas/requests/requests'),
                        'icon'        => 'icon-flag',
                        'permissions' => ['sas.requests.*'],
                        'order'       => 100,
                    ],
                    'requesttypes' => [
                        'label'       => 'Request Types',
                        'url'         => Backend::url('sas/requests/requesttypes'),
                        'icon'        => 'icon-cog',
                        'permissions' => ['sas.requests.*'],
                        'order'       => 102,
                    ],
                    'history' => [
                        'label'       => 'History',
                        'url'         => Backend::url('sas/requests/requests/history'),
                        'icon'        => 'icon-bar-chart',
                        'permissions' => ['sas.requests.*'],
                        'order'       => 105,
                    ],
                    'map' => [
                        'label'       => 'Map',
                        'url'         => Backend::url('sas/requests/requests/map'),
                        'icon'        => 'icon-globe',
                        'permissions' => ['sas.requests.*'],
                        'order'       => 105,
                    ],
                ],
            ],

        ];
    }
}
