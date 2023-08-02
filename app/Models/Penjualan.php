<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;


    protected $fillable = [
        'id',
        'tanggal',
        'pembeli',
        'nama_barang',
        'jumlah',
        'nominal',
    ];
}
