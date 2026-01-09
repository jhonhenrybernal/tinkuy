<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminValidationReason extends Model
{
    use HasFactory;
    protected $table = 'admin_validation_reasons';
    protected $fillable = ['value','label','is_active','is_system','sort_order'];
}
