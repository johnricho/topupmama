<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

abstract class Book extends Model implements CastsAttributes
{
    use FilterQueryString;
   // protected $filters =  ['sort','like','name','gender','age'];

    public static function searchBooks($search){
        if(!is_null($search)){
            try {
                return Self::findBooks($search);
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
        return Self::allBooks();
    }
    
    public static function findBook($id){
        try {
            $data = Http::acceptJson()->get('https://www.anapioficeandfire.com/api/books/'.$id);
            return response()->json([
                "status" => "success",
                'data' => $data->collect()->all(),
                "message" => "Books retrieved",
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
                "status" => [],
                "message" => "Error getting api request at the moment, try again. if error persist please check your network connection",
            ], 400);
        }
    }
    
    public static function allBooks(){
        $url = 'https://www.anapioficeandfire.com/api/books';
        try {
            $url = Http::acceptJson()->get($url);
           return response()->json([
            "status" => "success",
            'data' => $url->collect()->sortBy('released')->all(),
            "message" => "Books retrieved",
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
                "data" => [],
                "message" => "Error getting api request at the moment, try again. if error persist please check your network connection",
            ], 400);
        }
    }
 
    public static function findBooks($name){
        try {
            $books = new Collection();
            $url = 'https://www.anapioficeandfire.com/api/books';
            $data = Http::acceptJson()->get($url);
            $decoded = json_decode($data, true);
            if(!empty($name)){
                for($i=0; $i < count($decoded); $i++){
                    if((strpos($decoded[$i]['name'], $name) !== false)){// || str_contains($decoded[$i]['name'],$name)){
                        $books->push($decoded[$i]);
                    }
                }
                if($books->count()){
                    return response()->json([
                        "status" => "success",
                        'data' => $books->sortBy('release')->all(),
                        "message" => "Books retrieved",
                    ],200);
                }
                return response()->json([
                    "status" => "failed",
                    'data' => [],
                    "message" => "No book found for search criteria",
                ],404);
            }
            return response()->json([
                "status" => "failed",
                'data' => [],
                "message" => "No book found for search criteria",
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
