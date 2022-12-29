<?php namespace Bol\Eshop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use QrCode;
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
        $qr = QrCode::format('png')->size(50)->generate('Make me into an QrCode!');
// echo base64_encode($qr);
// dd('r');
        $templateCode = 'bol.eshop::pdf.invoice'; // unique code of the template
        $data = ['name' => 'John Doe', 'qr' => $qr]; // optional data used in template

        return PDF::loadTemplate($templateCode, $data)
        ->setPaper([0,0,192,96])
        // ->setPaper('A4')
        ->stream('download.pdf');
    }
}
