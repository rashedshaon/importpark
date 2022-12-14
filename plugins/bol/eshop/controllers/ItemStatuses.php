<?php namespace Bol\Eshop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class ItemStatuses extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'bol.eshop.manage_items_statuses' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bol.Eshop', 'main-menu-item', 'side-menu-item9');
    }
}
