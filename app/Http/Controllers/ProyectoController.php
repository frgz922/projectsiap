<?php
/**
 * Created by PhpStorm.
 * User: Faby's
 * Date: 6/1/2018
 * Time: 3:01 AM
 */

namespace App\Http\Controllers;

use App\Mail\sendFile;
use App\Models\Carrera;
use App\Models\Proyecto;
use App\Search\Filters\NombreFilter;
use App\Search\Search;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProyectoController extends Controller
{
    protected function validator(array $data)
    {
        $messages = [
            'nombre.required' => 'El nombre del proyecto es requerido.',
            'categoria.required' => 'La categoria del proyecto es requerido.',
            'autores.required' => 'Los autores del proyecto son requeridos.',
            'archivo.required' => 'El archivo del proyecto es requerido.'
        ];
        return Validator::make($data, [
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|integer',
            'autores' => 'required|string|max:255',
            'archivo' => 'required|file|mimes:docx,doc,pdf'
        ], $messages);
    }

    public function crearProyecto(Request $request)
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
            $archivo = $request->file('archivo');

            $directorio = Carrera::find(Auth::user()->carrera_id);


            $proyecto = new Proyecto();


            $proyecto->nombre = $data['nombre'];
            $proyecto->carrera_id = Auth::user()->carrera_id;
            $proyecto->usuario_id = Auth::id();
            $proyecto->categoria_id = $data['categoria'];
            $proyecto->fecha = Carbon::now();
            $proyecto->nombre_archivo = preg_replace('/\s+/', '', $archivo->getClientOriginalName());;
            $proyecto->autores = $data['autores'];

            $proyecto->save();


            $guardar = Storage::disk('uploads')->putFileAs('/', $archivo, preg_replace('/\s+/', '', $archivo->getClientOriginalName()));

            $proyecto->guardar = $guardar;

        }

        $success = true;
        $response = array(
            'success' => $success,
            'response' => $proyecto
        );
        return $response;
//        return $request->file('archivo-0')->getClientOriginalName();
    }

    public function editarProyecto(Request $request)
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
            $archivo = $request->file('archivo');

            $proyecto = Proyecto::find($data['id']);

            Storage::disk('uploads')->delete($proyecto->nombre_archivo);

            $proyecto->nombre = $data['nombre'];
            $proyecto->carrera_id = Auth::user()->carrera_id;
            $proyecto->usuario_id = Auth::id();
            $proyecto->categoria_id = $data['categoria'];
            $proyecto->fecha = Carbon::now();
            $proyecto->nombre_archivo = preg_replace('/\s+/', '', $archivo->getClientOriginalName());
            $proyecto->autores = $data['autores'];

            $proyecto->save();

            $guardar = Storage::disk('uploads')->putFileAs('/',$archivo, preg_replace('/\s+/', '', $archivo->getClientOriginalName()));

            $proyecto->guardar = $guardar;

        }

        $success = true;
        $response = array(
            'success' => $success,
            'response' => $proyecto
        );
        return $response;
    }

    public function eliminarProyecto(Request $request)
    {
//        $proyecto = Proyecto::destroy($request->id);

        $proyecto = Proyecto::find($request->id);

        Storage::disk('uploads')->delete($proyecto->nombre_archivo);

        if ($proyecto->delete()) {
            $msj = 'Registro eliminado con éxito.';
            $proyecto = 1;
        } else {
            $msj = 'Ocurrió un error al momento de eliminar el registro. Por favor intente de nuevo.';
            $proyecto = 0;
        }

        return array('eliminado' => $proyecto, 'msj' => $msj);
    }

    public function consultarProyectoPorID(Request $request)
    {
        $proyecto = Proyecto::with('categoria')
            ->where('id', '=', $request->id)
            ->where('carrera_id', Auth::user()->carrera_id)
            ->orderBy('nombre', 'asc')
            ->get();

        return $proyecto;
    }

    public function consultarProyectos(Request $request)
    {
        $proyectos = Proyecto::with('categoria')
            ->where('carrera_id', Auth::user()->carrera_id)
            ->orderBy('nombre', 'asc')
            ->get();

        return response()->json($proyectos);
    }

    public function enviarProyectoEmail(Request $request)
    {

        $proyecto = Proyecto::find($request->id);

        $url = Storage::disk('uploads')->get($proyecto->nombre_archivo);
        $extension = \File::extension($proyecto->nombre_archivo);

        $extension = $extension == 'pdf' ? 'pdf' : 'msword';

        Mail::to($request->email)->send(new sendFile($url, $proyecto->nombre, $extension));
        if (Mail::failures()) {
            $response = array(
                'success' => false,
                'response' => 'error'

            );
            return $response;
        }
        $response = array(
            'success' => true,
            'response' => 'ok'

        );
        return $response;

//        return array('p' => $proyecto, 'u' => $extension);
    }

    public function filterProyectos(Request $request)
    {
        if ($request->input('categoria') == null || $request->input('categoria') == '') {
            $except = $request->except('categoria');
            $request = new Request();

            $request->replace($except);
        }

        $search =  Search::apply($request);

        if (count($search) > 0) {
            $response = array(
                'success' => true,
                'result' => $search
            );
        } else {
            $response = array(
                'success' => false,
                'msg' => 'No se encontraron resultados según los criterios de la búsqueda.'
            );
        }


        return $response;

    }
}