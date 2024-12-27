<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'qr_code_data',
    ];
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
