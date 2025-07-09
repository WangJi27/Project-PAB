<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'pengarang', 'kategori'];

   public function peminjamans()
{
    return $this->hasMany(\App\Models\Peminjaman::class);
}


    public function getTersediaAttribute()
{
    return !$this->peminjamans()->whereNull('tanggal_kembali')->exists();
}

}
