<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    protected $primaryKey = 'employee_id';

    protected $fillable = [
        'employee_name',
        'email',
        'phone',
        'address',
        'position',
        'profile_picture'
    ];

    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute()
    {
        if ($this->profile_picture) {
            return asset('storage/' . $this->profile_picture);
        }
        return asset('images/default-avatar.png'); // Make sure to add a default avatar image
    }

    protected $visible = [
        'employee_id',
        'employee_name',
        'email',
        'phone',
        'address',
        'position',
        'profile_picture',
        'avatar_url',
        'created_at'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function attendance() {
        return $this->hasMany(Employee_Attendance::class, 'employee_id', 'employee_id');
    }
}
