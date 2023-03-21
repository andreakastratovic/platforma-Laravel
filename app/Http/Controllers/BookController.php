<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        $my_books=array();
        foreach($books as $book){
            array_push($my_books,new BookResource($book));
        }

        return $my_books;
    }

    public function myBooks(Request $request){
        $books=Book::get()->where('user_id',Auth::user()->id);
        if(count($books)==0){
            return 'You do not have saved!';
        }
        $my_books=array();
        foreach($books as $book){
            array_push($my_books,new BookResource($book));
        }

        return $my_books;
    }

    public function getByGenre($genreid){
        $books=Book::get()->where('genreid',$genrename);

        if(count($books)==0){
            return response()->json('Book with this genre does not exist!');
        }

        $my_books=array();
        foreach($books as $book){
            array_push($my_books,new BookResource($book));
        }

        return $my_books;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|String|max:255',
            'author'=>'required|String|max:255',
            'releaseYear'=>'required|Integer|max:2023',
            'genrename'=>'required',
            //'user_id'=>'required'
            
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $book=new Book;
        $book->name=$request->name;
        $book->author=$request->author;
        $book->releaseYear=$request->releaseYear;
        $book->user_id=Auth::user()->id;
       
        $book->save();

        return response()->json(['Book is saved successfully!',new BookResource($book)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $validator=Validator::make($request->all(),[
    
            'name'=>'required|String|max:255',
            'author'=>'required|String|max:255',
            'releaseYear'=>'required|Integer|max:2023',
            'genrename'=>'required',
            //'user_id'=>'required'


        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        
        $book->name=$request->name;
        $book->author=$request->author;
        $book->releaseYear=$request->releaseYear;
        $book->user_id=Auth::user()->id;
        

        $result=$book->update();

        if($result==false){
            return response()->json('Difficulty with updating!');
        }
        return response()->json(['Book is updated successfully!',new BookResource($book)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json('Book '.$auto->name .' is deleted successfully!');
    }
}
