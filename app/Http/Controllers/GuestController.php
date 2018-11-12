<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Yajra\DataTables\Html\Builder;
use App\Book;
use Laratrust\LaratrustFacade as Laratrust;

class GuestController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()) {    
            $books = Book::with('author');
            return Datatables::of($books)
            ->addColumn('stock', function($book){
                return $book->stock;
                })                
            ->addColumn('action', function($book){
                if(Laratrust::hasRole('admin')) return '';
                    return '<a class="btn btn-xs btn-primary" href="'.route('guest.books.borrow', $book->id).'">Pinjam</a>';
            })->make(true);
        }
        $html = $builder->columns([
            ['data' => 'title', 'name'=>'title', 'title'=>'Judul'],
            ['data' => 'author.name', 'name'=>'author.name', 'title'=>'Penulis'],
            ['data' => 'stock', 'name'=>'stock', 'title'=>'Stok', 'orderable'=>false, 'searchable'=>false],
            ['data' => 'action', 'name'=>'action', 'title'=>'', 'orderable'=>false,'\searchable'=>false]
        ]);
        return view('guest.index')->with(compact('html')); 
    }
}
