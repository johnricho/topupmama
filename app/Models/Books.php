<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

abstract class Books extends Model implements CastsAttributes
{
    use FilterQueryString;
   // protected $filters =  ['sort','like','name','gender','age'];

    public static function findByBooks(){
        $url = 'https://www.anapioficeandfire.com/api/books';
        try {
            $url = Http::acceptJson()->get($url);
            $collection = $url->collect();
            return  $collection->sortDesc();
        } catch (Exception $e) {
            return ["response"=>[
                "status" => "failed",
                "message" => "Error getting api request at the moment, try again. if error persist please check your network connection",
            ]];
        }
    }
 

    public static function findByBooksName($name){
        try {
            $url = Http::get('https://www.anapioficeandfire.com/api/books', [
                'name' => $name,
            ]);
            $collection = collect(json_decode(file_get_contents($url), true));
            $books = ["books"=>$collection->sort()];
            for($i=0; $i <= count($books["books"]); $i++){
                if(in_array($name,$books["books"])){
                    return $books["books"][$i]["name"];
                }
            }
        } catch (Exception $e) {
            return ["response"=>[
                "status" => "failed",
                "message" => "Error getting list of books request at the moment, try again. if error persist please check your network connection",
            ]];
        }
    }

    public static function findByBooksGender($name){
        try {
            $collection = collect(json_decode(file_get_contents('https://www.anapioficeandfire.com/api/books'), true));
            return $collection->sort();
        } catch (Exception $e) {
            return ["response"=>[
                "status" => "failed",
                "message" => "Error getting list of books request at the moment, try again. if error persist please check your network connection",
            ]];
        }
    }
}
