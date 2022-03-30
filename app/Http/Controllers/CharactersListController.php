<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\CharactersList;

class CharactersListController extends BaseController
{
    public function show(){
        return CharactersList::findByCharacter();
    }
    public function showById($id){
        return CharactersList::findByCharacterId($id);
    }
}
