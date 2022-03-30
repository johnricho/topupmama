<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

abstract class CharactersList extends Model
{
    use FilterQueryString;
    protected $filters = ['sort','like','name','gender','age'];
    public static function findByCharacter(){
        try{
            $url = Http::acceptJson()->get('https://www.anapioficeandfire.com/api/charaters');
            $collection = $url->collect();
            return  $collection->sortDesc();
    }catch (Exception $e) {
        return ["response"=>[
            "status" => "failed",
            "message" => "Error getting list of books request at the moment, try again. if error persist please check your network connection",
        ]];
    }
    }
    public static function findByCharacterId($id){
        try{
        $url = "https://www.anapioficeandfire.com/api/characters/{$id}";
        $collection = collect(json_decode(file_get_contents($url), true));
        $character = ["characters"=>$collection->sort()];
        return $character;
    }catch (Exception $e) {
        return ["response"=>[
            "status" => "failed",
            "message" => "Error getting list of books request at the moment, try again. if error persist please check your network connection",
        ]];
    }
    }

    
}
