<?php

namespace App\Admin\Actions\Grid;

use App\Models\Email;
use Illuminate\Http\Request;
use Dcat\Admin\Widgets\Modal;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Actions\Response;
use App\Admin\Forms\ReplyEmailForm;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class ReplyAction extends RowAction
{
    /**
     * @return string
     */
	protected $title = 'Reply';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // dump($this->getKey());



        return $this->response()
            ->success('Processed successfully: '.$this->getKey());
    }

    /**
	 * @return string|array|void
	 */
	public function confirm()
	{
		// return ['Confirm?', 'contents'];
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
    protected function parameters()
    {
        return [];
    }

    public function render()
    {
        // $email = Email::find($this->getKey());
        // dd($email);
        // 实例化表单类并传递自定义参数
        $form = ReplyEmailForm::make()->payload([
            'id' => $this->getKey(),
            'title' => $this->title
        ]);

        return Modal::make()
            ->xl()
            ->title($this->title)
            ->body($form)
            ->button($this->title);
    }

}
