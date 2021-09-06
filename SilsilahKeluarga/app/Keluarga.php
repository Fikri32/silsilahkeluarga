<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluargas';
    protected $fillable = ['nama','jk','parent_id'];

     public function parent()
    {
        return $this->belongsTo(Keluarga::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Keluarga::class, 'parent_id');
    }
}
