<?php

namespace App\Models\API;

use App\MyApp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = "product";
    protected $fillable = ["name", "id_type"];
    protected $casts = MyApp::datetime;

    //ClassModel::with('other_table')->get();
    //public function other_table(){
    //    return $this->belongsTo(OtherTable::class, 'id_other_table', 'id');
    //}

    //ClassModel::with('other_table')->get();
    //public function other_table(){
    //    return $this->hasMany(OtherTable::class, 'id_other_table', 'id');
    //}
    
    //ClassModel::with('other_table')->get();
    //public function other_table(){
    //    return $this->hasOne(OtherTable::class, 'id_other_table', 'id');
    //}
}
