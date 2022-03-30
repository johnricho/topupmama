<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Books;
use Laravel\Lumen\Http\ResponseFactory;

class BooksController extends BaseController
{
    //
    public function index(){
        return response()->json([
            'status' => 'success',
            'author' => 'John Ojebode (Johnricho)',
            'message' => 'You are welcome to my TopupMama restful api!'
        ],200);
    }
    public function show(){
        return Books::findByBooks();
    }
    public function showByName($name){
        return Books::findByBooksName($name);
    }

    public function showByGender($name){
        return Books::findByBooksGender($name);
    }
}
