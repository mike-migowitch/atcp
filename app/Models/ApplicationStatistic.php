<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperApplicationStatistic
 */
class ApplicationStatistic extends Model
{
    use HasFactory;

    public $timestamps = false;
}
