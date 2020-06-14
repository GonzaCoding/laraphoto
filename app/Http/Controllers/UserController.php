<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;

class UserController extends Controller {
    
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index($search = null){
        if(!empty($search)){
            $users = User::where('nick','LIKE','%'.$search.'%')
                    ->orWhere('name','LIKE','%'.$search.'%')
                    ->orWhere('surname','LIKE','%'.$search.'%')
                    ->orderBy('id','desc')
                    ->paginate(5);
        } else {
            $users = User::orderBy('id','desc')->paginate(5);
        }
        return view('user.index', [
            'users' => $users
        ]);
    }
    
    public function config() {
        return view('user.config');
    }

    public function update(Request $request) {

        // conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;

        //validar
        $validate = $this->validate($request, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,' . $id, //tiene que ser único, pero puede ser el nick actual
            'email' => 'required|string|email|max:255|unique:users,email,' . $id //idem
        ]);


        // tomar datos del form
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        // asignar valores
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;


        //subir la imagen
        $image_path = $request->file('image_path');
        //var_dump($image_path);
        //die();
        if ($image_path) {
            //poner nombre unico
            $image_path_name = time().$image_path->getClientOriginalName();

            /*// Borramos la imagen anterior
            
            // Existe la imagen anterior?
            if (\Auth::user()->image) {
                // Existe, entonces la borramos
                Storage::disk('users')->delete(\Auth::user()->image);
            }*/
            
            // Ahora guardamos la nueva imagen
            //guaradr en storage/app/users
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //setear valor en el objeto para luego guardar en la BD
            $user->image = $image_path_name;
        }

        //ejecutar update
        $user->update();

        return redirect()->route('config')
                        ->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function getImage($filename) {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
    
    public function profile($id){
        $user = User::find($id);
        
        return view('user.profile', [
            'user' => $user
        ]);
    }
    
    
}
