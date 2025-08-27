<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Product extends Model
{
    use Notifiable, SoftDeletes;
    protected $table = 'products';

    protected $fillable = [
        'nama_produk',
        'deskripsi_produk'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
            $model->save();
        });
    }
}
