<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Character;

class CharacterController extends BaseController
{
    public function show(Request $request){
        if($request->has('gender')){
            return Character::searchCharacter($request->gender,$request->sort,$request->order);
        }
        return Character::allCharacters();
    }
    
    public function showById($id){
        return Character::findCharacter($id);
    }
    
    public function showByName($name){
        return Character::findCharacters($name);
    }
}
