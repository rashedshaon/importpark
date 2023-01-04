<?php namespace Bol\Eshop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Carbon\Carbon;

class Customers extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'bol.eshop.manage_customers' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bol.Eshop', 'main-menu-item', 'side-menu-item12');

        $this->addCss('/plugins/bol/eshop/assets/css/style.css');
    }

    public function listInjectRowClass($record, $value)
    {
        $start_of_day = Carbon::today()->startOfDay();
        if ($record->has_remainder && $record->remainder_date <= $start_of_day) {
            return 'has-followup';
        }
    }
}
