<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_DetailPemesanan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'detail_pemesanan';
}
