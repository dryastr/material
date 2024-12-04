<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $fillable = [
        'kode',
        'id_barang',
        'id_pemesan',
        'qty',
        'note',
        'status_spv',
        'penolakan_spv',
        'status_admin',
        'penolakan_admin',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id')->withTrashed();
    }
    public function pemesan()
    {
        return $this->belongsTo(User::class, 'id_pemesan', 'id')->withTrashed();
    }
}
