<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Image;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function index(){
        $user = \Auth::user();
        $likes = Like::where('user_id', $user->id)
                ->orderBy('image_id','desc')->paginate(5);

        return view('like.index', [
           'likes' => $likes 
        ]);
    }
    
    public function like($image_id){
        //recoger datos del usuario y la imagen
        $user = \Auth::user();
        
        //condicion para ver si existe like y no duplicarlo
        $isset_like = Like::where('user_id', $user->id )
                          ->where('image_id', $image_id)
                          ->count();
        
        if($isset_like == 0) {
            $like = new Like();
            $like->user_id=$user->id;
            $like->image_id=(int)$image_id;

           //guarda
            $like->save();
            
            //para actualizar la cantidad de likes
            $likes = Like::where('image_id', '=', $image_id)->count();
            
            return response()->json([
               'like' => $like,
               'likes' => $likes
            ]);
        } else {
            return response()->json([
               'message' => 'El like ya existe' 
            ]);
        }
        
        
        
    }
    
    public function dislike($image_id){
        //recoger datos del usuario y la imagen
        $user = \Auth::user();
        
        //condicion para ver si existe like 
        $like = Like::where('user_id', $user->id )
                          ->where('image_id', $image_id)
                          ->first();
        
        if($like) {
            
           //guarda
            $like->delete();
            
            //para actualizar la cantidad de likes
            $likes = Like::where('image_id', '=', $image_id)->count();
            
            return response()->json([
               'like' => $like ,
               'likes' => $likes,
               'message' => 'Has dado dislike correctamente'
            ]);
        } else {
            return response()->json([
               'message' => 'El like no existe' 
            ]);
        }        
    }
    
    
}
