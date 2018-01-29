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
use Spatie\Dropbox\Client;

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

            $nombreArchivo = preg_replace('/\s+/', '', $archivo->getClientOriginalName());

            $guardar = Storage::disk('dropbox')->putFileAs('/', $archivo, $nombreArchivo);

            $Client = new Client('v3GxD1o2VOAAAAAAAAAACo1Kuof24BkTESk79F8y09X5Xm1u-7Ar_CYepu9kmsoU');
            $link = $Client->createSharedLinkWithSettings($nombreArchivo, array('requested_visibility' => 'public'));

            /*$proyecto = new Proyecto();

            $proyecto->nombre = $data['nombre'];
            $proyecto->carrera_id = Auth::user()->carrera_id;
            $proyecto->usuario_id = Auth::id();
            $proyecto->categoria_id = $data['categoria'];
            $proyecto->archivo = $link['url'];
            $proyecto->fecha = Carbon::now();
            $proyecto->nombre_archivo = $nombreArchivo;
            $proyecto->autores = $data['autores'];

            $proyecto->save();

            $proyecto->guardar = $guardar;*/

        }

        /*$success = true;
        $response = array(
            'success' => $success,
            'response' => $proyecto
        );
        return $response;*/

        return $link;
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

            Storage::disk('dropbox')->delete($proyecto->nombre_archivo);

            $nombreArchivo = preg_replace('/\s+/', '', $archivo->getClientOriginalName());

            $guardar = Storage::disk('dropbox')->putFileAs('/', $archivo, $nombreArchivo);

            $Client = new Client(env('DROPBOX_TOKEN'));
            $link = $Client->createSharedLinkWithSettings($nombreArchivo, array('requested_visibility' => 'public'));

            $proyecto->nombre = $data['nombre'];
            $proyecto->carrera_id = Auth::user()->carrera_id;
            $proyecto->usuario_id = Auth::id();
            $proyecto->categoria_id = $data['categoria'];
            $proyecto->fecha = Carbon::now();
            $proyecto->archivo = $link['url'];
            $proyecto->nombre_archivo = $nombreArchivo;
            $proyecto->autores = $data['autores'];

            $proyecto->save();

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

        Storage::disk('dropbox')->delete($proyecto->nombre_archivo);

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

        $url = $proyecto->archivo;
        $extension = \File::extension($proyecto->nombre_archivo);


//        $link = $Client->listSharedLinks($proyecto->nombre_archivo);
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

//        return array('p' => $link, 't' => $extension);
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