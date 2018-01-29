<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 2/1/2018
 * Time: 1:48 AM
 */

namespace App\Http\Controllers;


use App\Models\Categoria;
use App\Models\Proyecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('guest');
//    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => 'required|string|max:255',
            'carrera' => 'required|integer',
        ]);
    }

    public function crearCategoria(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);

        if ($validator->fails()) {
            $success = false;
            $response = array(
                'success' => $success,
                'response' => $validator->errors()
            );
            return response()->json($response);
        } else {
            $categoria = new Categoria();

            $categoria->nombre = $data['nombre'];
            $categoria->carrera_id = $data['carrera'];

            $categoria->save();
        }
        $success = true;
        $response = array(
            'success' => $success,
            'response' => $categoria
        );
        return $response;
    }

    public function consultarCategorias() {
        $categorias = Categoria::orderBy('nombre', 'asc')->get();
        return $categorias;
    }

    public function eliminarCategoria(Request $request) {
        $categoria = Categoria::destroy($request->id);
//        $categoria = 0;

        if ($categoria > 0) {
            $msj = 'Registro eliminado con éxito.';
        } else {
            $msj = 'Ocurrió un error al momento de eliminar el registro. Por favor intente de nuevo.';
        }

        return array('eliminado' => $categoria, 'msj' => $msj);
    }

    public function pruebas(Request $request) {
//        $categoria = Storage::disk('local')->put('Informatica/file.txt', 'Contents');
        $proyecto = Proyecto::find(1);
        return response()->json($proyecto->archivo);
    }
}