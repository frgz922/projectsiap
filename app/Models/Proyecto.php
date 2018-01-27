<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 2/1/2018
 * Time: 1:44 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Proyecto extends Model
{
    use Notifiable;
    protected $table = 'proyecto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'digital', 'fecha', 'nombre_archivo', 'autores', 'carrera_id', 'usuario_id', 'categoria_id'
    ];

    public function carrera()
    {
        return $this->belongsTo('App\Models\Carrera', 'carrera_id');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\User', 'usuario_id');
    }

    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'categoria_id');
    }


}