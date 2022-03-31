<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Book;
use Laravel\Lumen\Http\ResponseFactory;

class BookController extends BaseController
{
    //
    public function index(){
        return response()->json([
            'status' => 'success',
            'author' => 'John Ojebode (Johnricho)',
            'message' => 'You are welcome to my TopupMama restful api!'
        ],200);
    }

    public function show(Request $request){
        if($request->has('search')){
            return Book::searchBooks($request->search);
        }
        return Book::allBooks();
    }
    
    public function showById($id){
        return Book::findBook($id);
    }
    
    public function showByName($name){
        return Book::findBook($name);
    }
}
