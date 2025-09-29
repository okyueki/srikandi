<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPenilaian extends Model
{
    use HasFactory;

    protected $table = 'items_penilaian';

    protected $fillable = ['nama_item', 'bobot_nilai'];

    // Jika ada relasi yang terkait, tambahkan di sini
}