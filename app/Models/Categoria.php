<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 2/1/2018
 * Time: 1:43 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Categoria extends Model
{
    use Notifiable;
    protected $table = 'categoria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'carrera_id'
    ];

    public function carrera()
    {
        return $this->belongsTo('App\Models\Carrera', 'carrera_id');
    }
}