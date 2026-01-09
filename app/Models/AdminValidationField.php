<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminValidationField extends Model
{
    use HasFactory;
    protected $table = 'admin_validation_fields';
    protected $fillable = ['key','label','applies_to','is_active','sort_order'];
}
