<?php namespace Bol\Eshop\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

use Flash;
use Lang;
use Bol\Eshop\Models\Product;

class Products extends Controller
{
    public $implement = [
        'Backend\Behaviors\ListController',
        'Backend\Behaviors\FormController'
    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public $requiredPermissions = [
        'bol.eshop.manage_products' 
    ];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Bol.Eshop', 'main-menu-item', 'side-menu-item');
    }

    public function listExtendQuery($query)
    {
        if (!$this->user->hasAnyAccess(['bol.eshop.access_other_products'])) {
            $query->where('created_by', $this->user->id);
        }
    }

    public function formExtendQuery($query)
    {
        if (!$this->user->hasAnyAccess(['bol.eshop.access_other_products'])) {
            $query->where('created_by', $this->user->id);
        }
    }

    public function formExtendFieldsBefore($widget)
    {
        if (!$model = $widget->model) {
            return;
        }

    }

    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $postId) {
                if ((!$post = Product::find($postId)) || !$post->canEdit($this->user)) {
                    continue;
                }

                $post->delete();
            }

            Flash::success(Lang::get('bol.eshop::lang.product.delete_success'));
        }

        return $this->listRefresh();
    }

    /**
     * {@inheritDoc}
     */
    public function listInjectRowClass($record, $definition = null)
    {
        if (!$record->published) {
            return 'safe disabled';
        }
    }

    public function formBeforeCreate($model)
    {
        //$model->created_by = $this->user->id;
    }

    public function onRefreshPreview()
    {
        $data = post('Post');

        $previewHtml = Product::formatHtml($data['description'], true);

        return [
            'preview' => $previewHtml
        ];
    }
}
