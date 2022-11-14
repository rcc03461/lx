<?php

namespace App\Admin\Actions\Grid;

use App\Models\Invoice;
use Dcat\Admin\Actions\Response;
use Dcat\Admin\Grid\RowAction;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CreateInvoiceByTaskId extends RowAction
{
    /**
     * @return string
     */
	protected $title = 'Create Invoice';

    /**
     * Handle the action request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request)
    {
        // $inv = Invoice::find($this->getKey());
        // [$lx_number, $lx_code] = $inv->generateInvoiceNo();
        // $inv->lx_number = $lx_number;
        // $inv->lx_code = $lx_code;
        // $inv->save();

        // dump($inv->generateInvoiceNo());

        return $this->response()
            ->redirect('/invoices/create?task_id='.$this->getKey())
            ->success('Processed successfully: '.$this->getKey())
            // ->refresh()
            ;
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
}
