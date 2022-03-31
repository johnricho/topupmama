<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

abstract class Character extends Model
{
    use FilterQueryString;
    protected $filters = ['sort','like','name','gender','age'];
    public static function searchCharacter($filter,$sort,$order){
        if(!is_null($filter)){
            try {
                return Self::findCharacters($filter,$sort,$order);
            } catch (Exception $e) {
                return response()->json([
                    "status" => "failed",
                    "data" => [],
                    "message" => $e->getMessage(),
                ], 400);
            } catch (ConnectionException $e){
                return response()->json([
                    "status" => "failed",
                    "message" => "Error getting api request at the moment, try again. if error persist please check your network connection",
                ], 400);
            }
        }
        return Self::allCharacters();
    }

    public static function allCharacters(){
        try{
                $data = Http::acceptJson()->get('https://www.anapioficeandfire.com/api/characters');
                return response()->json([
                    "status" => "success",
                    'data' => $data->collect()->all(),
                    "message" => "Character retrieved",
                ],200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failed",
                "data" => [],
                "message" => $e->getMessage(),
            ], 400);
        } catch (ConnectionException $e){
            return response()->json([
                "status" => "failed",
                "message" => "Error getting api request at the moment, try again. if error persist please check your network connection",
            ], 400);
        }
    }

    public static function findCharacter($id){
        try{
            $data = Http::acceptJson()->get('https://www.anapioficeandfire.com/api/characters/'.$id);
            return response()->json([
                "status" => "success",
                'data' => $data->collect()->all(),
                "message" => "Character retrieved",
            ],200);
        } catch (Exception $e) {
            return response()->json([
                "status" => "failed",
                "data" => [],
                "message" => $e->getMessage(),
            ], 400);
        } catch (ConnectionException $e){
            return response()->json([
                "status" => "failed",
                "message" => "Error getting api request at the moment, try again. if error persist please check your network connection",
            ], 400);
        }
    }
 
    public static function findCharacters($gender,$sort,$order){
        try {
            $characters = new Collection();
            $url = 'https://www.anapioficeandfire.com/api/characters';
            $data = Http::acceptJson()->get($url);
            $decoded = json_decode($data, true);
            for($i=0; $i < count($decoded); $i++){
                $born = strtotime($decoded[$i]['born']);
                $death = (empty($decoded[$i]['death'])?date('Y-m-d h:i:sa'):strtotime($decoded[$i]['death']));
                $decoded[$i]['age'] = (empty($decoded[$i]['born'])?0 : $death->diff($born));
                if($decoded[$i]['gender']=$gender){
                    $characters->push($decoded[$i]);
                }
            }

            $ordered = ($order=='asc'? $characters->sortBy($sort)->all():$characters->sortByDesc($sort)->all());
            if(count($ordered)){
                return response()->json([
                    "status" => "success",
                    'data' => $ordered,
                    "message" => "Character retrieved",
                    "metadata" => [
                        'total' => count($ordered)
                    ]
                ],200);
            }
            return response()->json([
                "status" => "failed",
                'data' => [],
                "message" => "No character found for search criteria",
            ],404);

        } catch (Exception $e) {
            return response()->json([
                "status" => "failed",
                'data' => [],
                "message" => $e->getMessage(),
            ], 400);
        } catch (ConnectionException $e){
            return response()->json([
                "status" => "failed",
                'data' => [],
                "message" => "Error getting api request at the moment, try again. if error persist please check your network connection",
            ], 400);
        }
    }
}