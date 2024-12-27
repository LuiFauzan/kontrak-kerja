<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'transition_no',
        'career_transition',
        'transition_type',
        'position',
        'start_date',
        'end_date',
        'duration',
        'remark',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
