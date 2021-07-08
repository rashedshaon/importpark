<?php namespace Bol\Eshop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Categories extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController',
        'Backend\Behaviors\ReorderController'    
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';
    public $reorderConfig = 'config_reorder.yaml';

    public $requiredPermissions = [
        'bol.eshop.manage_categories' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bol.Eshop', 'main-menu-item', 'side-menu-item2');
    }

    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $categoryId) {
                if ((!$category = Category::find($categoryId))) {
                    continue;
                }

                $category->delete();
            }

            Flash::success(Lang::get('bol.eshop::lang.category.delete_success'));
        }

        return $this->listRefresh();
    }
}
