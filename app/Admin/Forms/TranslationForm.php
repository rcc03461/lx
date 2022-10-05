<?php

namespace App\Admin\Forms;

use App\Models\Task;
use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Form\NestedForm;
use Dcat\Admin\Traits\LazyWidget;
use Illuminate\Support\Facades\DB;
use Dcat\Admin\Contracts\LazyRenderable;

class TranslationForm extends Form implements LazyRenderable
{
    use LazyWidget;

    public function handle(array $input)
    {
        // 获取外部传递参数
        // $id = $this->payload['id'] ?? null;
        // $inventory = new Inventory;
        // dd($input);

        DB::beginTransaction();
        try {

            $payload = $this->payload;

            // if ($payload['key']) {

            //     $sample = Sample::find($payload['key']);
            //     $sample->update($input);

            //     $sample->producttypes()->detach();
            //     foreach ($input['producttypes'] as $key => $value) {
            //         $sample->producttypes()->attach($value['product_type_id'], ['sample_qty' => $value['sample_qty']]);
            //     }

            // }else{

            //     $sample = Sample::create($input);
            //     foreach ($input['producttypes'] as $key => $value) {
            //         $sample->producttypes()->attach($value['product_type_id'], ['sample_qty' => $value['sample_qty']]);
            //     }

            // }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return $this->response()->error('Processed Error.');
        }

        return $this->response()->success('Processed successfully.')->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {

        $this->display('id');
        $this->table('meta', 'Translations', function(NestedForm $table) {
            $table->text('section');
            $table->select("direction")->options([
                'e2c' => 'E > C',
                'c2e' => 'C > E',
                'cross-translation' => 'Cross-Translation',
                'client' => 'Client',
            ]);
        });

    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        $payload = $this->payload;


        if (!empty($payload['id'])) {
            $sample = Task::find($payload['id']);
            // dump($payload);
            return [
                'id'  => $payload['id'] ?? null,
                'meta' => $sample->meta ?? null,
            ];
        }
    }
}
