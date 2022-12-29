<?php namespace Bol\Eshop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Renatio\DynamicPDF\Classes\PDF; // import facade

class Purchases extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController', 'Backend.Behaviors.RelationController',     ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $requiredPermissions = [
        'bol.eshop.manage_purchases' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bol.Eshop', 'main-menu-item', 'side-menu-item7');
    }


    public function pdf()
    {
        $templateCode = 'renatio.dynamicpdf::pdf.header_and_footer'; // unique code of the template
        $data = ['name' => 'John Doe']; // optional data used in template

        return PDF::loadTemplate($templateCode, $data)->stream('download.pdf');
    }
}
