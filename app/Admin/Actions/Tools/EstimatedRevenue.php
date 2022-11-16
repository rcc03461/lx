<?php

namespace App\Admin\Actions\Tools;

use Illuminate\Http\Request;
use Dcat\Admin\Actions\Action;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class EstimatedRevenue extends Action
{
    /**
     * @return string
     */
	protected $title = 'Estimated Revenue';
	// public $product_type_id = 0;


    protected $action;

    // 注意action的构造方法参数一定要给默认值
    // public function __construct($product_type_id)
    // {
    //     // $this->title = $title;
    //     $this->product_type_id = $product_type_id;
    // }


    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // $type = $this->getKey();

        return $this->response()
            ->success('Processing completed.')
            ->script(<<<JS
window.open('/admin/print/estimated-revenue', '_blank', 'width=1200,height=980');
JS);

    }


    /**
     * 设置HTML标签的属性
     *
     * @return void
     */
    protected function setupHtmlAttributes()
    {
        // 添加class
        $this->addHtmlClass('btn btn-primary');

        // 保存弹窗的ID
        // $this->setHtmlAttribute('data-target', '#'.$this->modalId);

        parent::setupHtmlAttributes();
    }

    /**
     * @return string|array|void
     */
    public function confirm()
    {
        // return ['Confirm?', 'Will Assign Product grogress to Product Type!!'];
    }

    /**
     * @param Model|Authenticatable|HasPermissions|null $user
     *
     * @return bool
     */
    protected function authorize($user): bool
    {
        return true;
    }

    /**
     * @return array
     */
    // protected function parameters()
    // {
    //     return [
    //         'product_type_id'
    //     ];
    // }
}
