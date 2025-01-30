<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tarea;
use Illuminate\Support\Facades\Validator;

class tareaController extends Controller
{
    public function index(){
        $tareas = Tarea::all();
        if($tareas->isEmpty()){
            $data = [
                'message' => 'No hay tareas',
                'status' => 200
            ];
            return response()->json($data, 400);
        }
        return response()->json($tareas,200);
    }

    public function store(Request $request){
        $validacion = Validator::make($request->all(),[
            'nombre' => 'required|max:255|unique:tarea',
            'descripcion' => 'required|max:255'
        ]);
    
        if($validacion->fails()){
            $data = [
                'message' => 'Error en la validación de los datos',
                'errors' => $validacion->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }
    
        try {
            $tarea = Tarea::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'estado' => '1'
            ]);
    
            $data = [
                'tarea' => $tarea,
                'status' => 201
            ];
    
            return response()->json($data, 201);
    
        } catch (\Exception $e) {
            $data = [
                'message' => 'Error al crear la tarea',
                'error' => $e->getMessage(),
                'status' => 500
            ];
            return response()->json($data, 500);
        }
    }
    
    public function update($id)
    {
        $tarea = Tarea::where('id', $id)->where('estado', '1')->first();
        if (!$tarea) {
            $data = [
                'message' => 'Tarea no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $fechaHoraActual = now()->setTimezone('America/Bogota');
        $tarea->fechaHoraFinalizacion = $fechaHoraActual;
        $tarea->save();
        $data = [
            'message' => 'Fecha y hora de finalización actualizada correctamente',
            'tarea' => $tarea,
            'status' => 200
        ];
        return response()->json($data, 200);
    }


    public function destroy($id)
    {
        $tarea = Tarea::where('id', $id)->where('estado', '1')->first();
        if (!$tarea) {
            $data = [
                'message' => 'Tarea no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }
    
        //$tarea->delete();  
        $tarea->estado = '0';
        $tarea->save();
        $data = [
            'message' => 'Tarea eliminada correctamente',
            'status' => 200
        ];
        return response()->json($data, 200);
    }
    






}
