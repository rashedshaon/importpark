<?php namespace Bol\Eshop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Orders extends Controller
{
    public $implement = [ 
        'Backend\Behaviors\ListController', 
        'Backend\Behaviors\FormController',
        'Backend.Behaviors.RelationController',
    ];

    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'bol.eshop.manage_orders' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bol.Eshop', 'main-menu-item', 'side-menu-item4');

        $this->addCss('/plugins/bol/eshop/assets/css/style.css');
    }

    public function preview($id)
    {
        $this->vars['id'] = $id;
        parent::preview($id);
    }
}
