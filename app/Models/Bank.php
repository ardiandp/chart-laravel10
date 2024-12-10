<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'bank';

    protected $fillable = [
        'tanggal',
        'keterangan',
        'cabang',
        'jumlah',
        'tipe_transaksi',
        'saldo',
    ];
}
