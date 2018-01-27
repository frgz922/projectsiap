<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 1/1/2018
 * Time: 3:42 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Carrera extends Model
{
    use Notifiable;
    protected $table = 'carrera';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];
}