<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use DataTables;
use Yajra\DataTables\Html\Builder;
use Session;
class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            return DataTables::of(Author::all('id','name'))
            ->addColumn('action', function($author){
                return view('authors._action', [
                    'model' => $author,
                    'edit_url' => route('penulis.edit', $author->id),
                    'form_url' => route('penulis.destroy', $author->id),
                    'confirm_message' => 'Yakin mau menghapus ' . $author->name . '?',
                ]);
            })->toJson();
        }
        $html = $builder->columns([
                ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
                ['data' => 'name', 'name' => 'name', 'title' => 'Nama'],
                ['data' => 'action', 'name'=>'action', 'title'=>'', 'orderable'=>false,'\searchable'=>false]
            ]);
        return view('authors.index', compact('html'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            return view('authors.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            ['name' => 'required|unique:authors']
        );
        $author = Author::create($request->all());
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan $author->name"
            ]);           
        return redirect()->route('penulis.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $author = Author::find($id);
        return view('authors.edit')->with(compact('author'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['name' => 'required|unique:authors,name,'. $id]);
        $author = Author::find($id);
        $author->update($request->only('name'));
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan $author->name"
        ]);
        return redirect()->route('penulis.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!Author::destroy($id)) return redirect()->back();
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Penulis berhasil dihapus"
        ]);            
        return redirect()->route('penulis.index');
        
    }
}
