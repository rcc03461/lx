<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Models\Label;
use Dcat\Admin\Admin;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Content;
use App\Admin\Repositories\Email;
use Illuminate\Support\Collection;
use App\Admin\Forms\ReplyEmailForm;
use App\Models\Email as ModelEmail;
use App\Admin\Actions\Grid\ReplyAction;
use App\Admin\Actions\Grid\RefreshLatestEmail;
use Dcat\Admin\Http\Controllers\AdminController;

class EmailController extends AdminController
{



    public function index(Content $content)
    {
        return $content
            ->header('Email')
            // ->description('合并表头功能示例')
            ->body(function ($row) {
                // $row->column(4, new TotalUsers());
                // $row->column(4, new NewUsers());
                // $row->column(4, new NewDevices());
            })
            ->body($this->grid());
    }

    public function guessRef( String $str ){
        // RE: New ADV : 23908_AD(1) : 1130 - Appointment of ED  => 23908_AD(1)
        // New ADV : 23908_AD(1) : 1130 - Appointment of ED => 23908_AD(1)
        // <Cmts>: 23869_Cir : Okura - Circular on amendments to 1st Series Bond (Eng) => 23869_Cir
        // 23771_AD[1] - Okura Holding - MAJOR TRANSACTION FURTHER AMENDMENTS TO THE TERMS AND CONDITIONS OF THE 1ST SERIES BOND - ADV will announce today => 23771_AD[1]
        return str($str)->match('/(\d+_[a-zA-Z]+[\(\[]?.?[\)\]]?)/')->trim();
        // return preg_replace('//', '_', $str);

    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        return Grid::make(new Email([
                'labels'
            ]), function (Grid $grid) {

            $grid->selector(function (Grid\Tools\Selector $selector) {

                $labels = Label::where('type', 'user')->orderBy('name')->pluck('name','ref_id');

                $selector->select('labels', 'Labels', $labels, function($query, $value){
                    $value = current($value);
                    // dd($value);
                    $query->hasByNonDependentSubquery('labels', function($q) use($value){
                        $q->where('ref_id', $value);
                    });
                });
                // $selector->select('category', '类别', ['茶几', '地柜式', '边几', '布艺沙发', '茶台', '炕几']);
                // $selector->select('style', '风格', ['现代简约', '新中式', '田园风', '明清古典', '北欧', '轻奢', '古典']);
                // $selector->selectOne('price', '售价', ['0-599', '600-1999', '1999-4999', '5000+']);
                $selector->select('mailbox', 'Is Sent', [
                    'Inbox' => 'Inbox',
                    'Sent' => 'Sent',
                ], function($query, $value){
                    $value = current($value);
                    if($value == 'Inbox'){
                        $query->doesntHaveByNonDependentSubquery('labels', function($q) use($value){
                            $q->where('ref_id', 'SENT');
                        });
                    }
                    if($value == 'Sent'){
                        $query->hasByNonDependentSubquery('labels', function($q) use($value){
                            $q->where('ref_id', 'SENT');
                        });
                    }
                });
            });

            $grid
            ->model()
            ->doesntHaveByNonDependentSubquery('labels', function($q){
                $q->whereIn('ref_id', [ 'DRAFT' ]);
            })
            ->orderByDesc('email_datetime');

            $grid->addTableClass('table-slim');
            // $grid->setKeyName("123");
            // $grid->column('id')->sortable();
            // $grid->column('message_id')
            // // ->setAttributes(['data-message-id' => $grid->model])
            // ;
            $grid->column('from')->display(function($val){
                return '<div title="'. $val->email. '">'. $val->name. '</div>';
            });
            if (str(url()->full())->contains('Sent')) {
                $grid->column('to')->display(function($vals){
                    return collect($vals)->map(fn($v)=>$v['name'])->join(', ');
                });
            }
            // $grid->column('cc');
            // $grid->column('bcc');
            $grid->column('subject')
            ->display(function($val){
                return view('admin.rows.subject', [
                    'labels' => $this->labels,
                    'subject' => $val,
                    'ref' => $this->ref,
                    'email_datetime' => $this->email_datetime,
                    'has_attachments' => $this->has_attachments
                ]);
            });
            // ->modal(function (Grid\Displayers\Modal $modal) {
            //     // 标题
            //     $modal->title('弹窗标题');
            //     // 自定义图标
            //     $modal->icon('feather icon-edit');
            //     // 传递当前行字段值
            //     return EmailReply::make()->payload(['name' => $this->subject]);
            // });
            // $grid->column('html_body');
            // $grid->column('text_body');
            // $grid->column('email_datetime')->sortable();
            // $grid->column('has_attachments');
            // $grid->column('created_at');
            // $grid->column('updated_at')->sortable();

            // $grid->filter(function (Grid\Filter $filter) {
            //     $filter->equal('id');

            // });
            // $grid->async();
            $grid->rows(function (Collection $rows) {
                $rows = $rows->each(function ($item, $key) {
                    $item->setAttributes([
                        'data-message-id' => $item->message_id,
                        'data-message-labels' => collect($item->labels)->pluck('ref_id'),
                        'data-ref' => $item->ref,
                        'data-guess' => $this->guessRef($item->subject),
                    ]);
                });
            });
            $grid->simplePaginate();
            $grid->tableCollapse(false);
            $grid->quickSearch([
                'from', 'to', 'subject', 'ref'
            ]);
            // $grid->showQuickEditButton();
            $grid->disableActions();
            $grid->disableViewButton();
            $grid->disableEditButton();
            $grid->disableDeleteButton();
            $grid->disableCreateButton();

            $grid->tools([
                RefreshLatestEmail::make(),
            ]);
            // $grid->actions([
            //     ReplyAction::make('Reply All'),
            //     ReplyAction::make('Reply'),
            //     ReplyAction::make('Forward'),
            // ]);
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    public function info(ModelEmail $message){
        return $message->loadMissing([
            'labels'
        ]);
    }
    protected function detail($id)
    {
        return Show::make($id, new Email(), function (Show $show) {
            $show->field('id');
            $show->field('message_id');
            $show->field('from');
            $show->field('to');
            $show->field('cc');
            $show->field('bcc');
            $show->field('subject');
            $show->field('html_body');
            $show->field('text_body');
            $show->field('email_datetime');
            $show->field('has_attachments');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Email(), function (Form $form) {
            // $form->row(function ($form) {

                $form->display('id');
                $form->text('message_id')->readOnly();
                // dd($form['from']);
                $form->embeds('from', function($field){
                    // $field->row(function ($field) {
                        $field->text('name');
                        $field->text('email');
                    // });
                });
                // $form->text('from', 'From Email');
                $form->table('to', function($field){
                    $field->text('name');
                    $field->text('email');
                });
                $form->table('cc', function($field){
                    $field->text('name');
                    $field->text('email');
                });
                $form->table('bcc', function($field){
                    $field->text('name');
                    $field->text('email');
                });
                $form->text('subject');
                $form->editor('html_body')->options([
                    "content_css" => '/assets/css/editor_content.css'
                ]);
                $form->text('email_datetime');
                $form->text('has_attachments');

                $form->display('created_at');
                $form->display('updated_at');
            // });
        });
    }

    public function contacts(){
        $from = ModelEmail::select('from')
        ->distinct( 'from' )
        // ->take(100)
        ->get()
        ->pluck('from.email')
        //remove null
        ->filter();
        $to = ModelEmail::select('to')
        ->latest()
        ->take(500)
        ->get()
        ->pluck('to.*.email')
        ->flatten()

        ->filter();

        return $from->merge($to)->unique()->sort()->values();

    }

    public function labels(){
        return Label::all();
    }
    public function updateLabels( Request $request, ModelEmail $message ){

        // $request->validate([
        //     'labels' => 'array|required'
        // ]);
        $labels = request('labels', []);
        if(count($labels)){
            $label_id = Label::whereIn('ref_id',request('labels'))->pluck('id');
            $message->labels()->sync($label_id);
            return response()->json([
                // "code" => 0,
                'status' => true,
                'message' => 'Labels updated successfully.']
            );
        }else{
            $message->labels()->detach();
            return response()->json([
                // "code" => 0,
                'status' => true,
                'message' => 'Labels updated successfully.']
            );
        }
        // return response()->json([
        //     // 'code' => 401,
        //     'status' => false,
        //     'message' => 'Labels updated successfully.']
        // );
        // dd($labels);
        // return  $labels;

        // dd($message);
        // dd(request()->all());
    }
    public function updateEmail( ModelEmail $message ){
        // dd(request()->all());
        // return $message;
        $message->update(request()->all());
    }
}
