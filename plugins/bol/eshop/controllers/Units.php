<?php namespace Bol\Eshop\Controllers;

use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use BackendMenu;

class Units extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'bol.eshop.manage_units' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('Bol.Eshop', 'eshop-menu-units');
    }
}
