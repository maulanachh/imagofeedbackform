<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Feedback extends Model
{
    use Notifiable, SoftDeletes;
    protected $table = 'feedback';

    protected $fillable = [
        'produk_id',
        'nama_user',
        'email_user',
        'komentar_user'
    ];

    protected static function booted()
    {
        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
            $model->save();
        });
    }
}
