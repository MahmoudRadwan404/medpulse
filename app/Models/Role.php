<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $fillable=['name','description'];
    protected $guarded=['id'];
    protected $table='role';


    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission');
    }
    // public function experts()
    // {
    //     return $this->hasMany(Expert::class, 'role_id');
    // }
}
