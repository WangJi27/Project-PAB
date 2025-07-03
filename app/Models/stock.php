<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Stock extends Model
{
    protected $table = 'stocks';

    protected $fillable = [
        'barang_id',
        'gudang_id',
        'balance',
    ];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function gudang(): BelongsTo
    {
        return $this->belongsTo(Gudang::class, 'gudang_id', 'id');
    }

    public function transaksi(): HasMany
    {
        return $this->hasMany(TransaksiStock::class, 'stock_id', 'id');
    }

    
    public function hasBalance(Builder $query):void
    {
        $query->where('balance','>',0);
    }
   
    public function noBalance(Builder $query):void
    {
        $query->where('balance',0);
    }
}