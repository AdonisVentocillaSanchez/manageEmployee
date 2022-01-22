<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employeer extends Model
{
    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
      protected $fillable = [
        'nombre', 'apellidos', 'dni', 'email', 'fecha_nacimiento', 'cargo', 'area', 'fecha_inicio','fecha_fin','tipo_contacto','estado', 'profile_photo_path', 'deleted_at', 'created_at', 'updated_at'
    ];
}
