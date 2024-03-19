<?php

namespace App\Traits;

use App\Models\Label;

trait HasLabels
{
    public function labels( $type = 'user' ){
        // return $this->morphToMany(Label::class, 'labelable');
        return $this->morphToMany(Label::class, 'labelable')->when($type = 'user', function($q) use($type){
            $q->where('type', $type);
        });
    }

    public function syncLabels($ids){
        $labels = Label::whereIn('ref_id', $ids)->get();
        $this->labels()->sync($labels);
        return $this;
    }

}
