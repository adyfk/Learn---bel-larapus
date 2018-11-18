<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Book;
use DataTables;
use Yajra\DataTables\Html\Builder;
use Session;
use File;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\BorrowLog;
use Auth;
use Excel;
use App\Exceptions\BookException;
use PDF;
use App\Exports\BooksExport;
use App\Http\Controllers\Controller;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $book=Book::with('author');
            return DataTables::of($book)
            ->addColumn('action', function($book){
                return view('books._action', [
                    'model' => $book,
                    'edit_url' => route('buku.edit', $book->id),
                    'form_url' => route('buku.destroy', $book->id),
                    'confirm_message' => 'Yakin mau menghapus ' . $book->name . '?',
                ]);
            })->make(true);
        }        
        $html = $builder->columns([
                ['data' => 'title', 'name'=>'title', 'title'=>'Judul'],
                ['data' => 'amount', 'name'=>'amount', 'title'=>'Jumlah'],
                ['data' => 'author.name', 'name'=>'author.name', 'title'=>'Penulis'],
                ['data' => 'action', 'name'=>'action', 'title'=>'', 'orderable'=>false,'\searchable'=>false]
            ]);
        return view('books.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {        
        //insert selain cover
        $book = Book::create($request->except('cover'));
        // isi field cover jika ada cover yang diupload
        if ($request->hasFile('cover')) {
            ?>
            <script>
                alert('hoi');
            </script>
            <?php
            // Mengambil file yang diupload
            $uploaded_cover = $request->file('cover');
            // mengambil extension file
            $extension = $uploaded_cover->getClientOriginalExtension();
            // membuat nama file random berikut extension
            $filename = md5(time()) . '.' . $extension;
            // menyimpan cover ke folder public/img
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            $uploaded_cover->move($destinationPath, $filename);
            // mengisi field cover di book dengan filename yang baru dibuat
            $book->cover = $filename;
            $book->save();
        }
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan $book->title"
        ]);
        return redirect()->route('buku.index');
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
        $book = Book::find($id);
        return view('books.edit')->with(compact('book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, $id)
    {
        $book = Book::find($id);
        if(!$book->update($request->all())) return redirect()->back();
        if ($request->hasFile('cover')) {
            // menambil cover yang diupload berikut ekstensinya
            $filename = null;
            $uploaded_cover = $request->file('cover');
            $extension = $uploaded_cover->getClientOriginalExtension();
            // membuat nama file random dengan extension
            $filename = md5(time()) . '.' . $extension;
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'img';
            // memindahkan file ke folder public/img
            $uploaded_cover->move($destinationPath, $filename);
            // hapus cover lama, jika ada
            if ($book->cover){
                $old_cover = $book->cover;
                $filepath = public_path() . DIRECTORY_SEPARATOR .'img'. DIRECTORY_SEPARATOR . $book->cover;
                try {
                    File::delete($filepath);
                }catch (FileNotFoundException $e) {
                    // File sudah dihapus/tidak ada
                }
            }
            // ganti field cover dengan cover yang baru
            $book->cover = $filename;
            $book->save();
        }
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"Berhasil menyimpan $book->title"
        ]);
        return redirect()->route('buku.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        // hapus cover lama, jika ada
        $cover = $book->cover;
        if(!$book->delete()) return redirect()->back();
        if ($cover){
            $old_cover = $book->cover;
            $filepath = public_path() . DIRECTORY_SEPARATOR .'img'. DIRECTORY_SEPARATOR . $book->cover;
            try {
                File::delete($filepath);
            } catch (FileNotFoundException $e) {
                // File sudah dihapus/tidak ada
            }
        }
        Session::flash("flash_notification", [
            "level"=>"success",
            "message"=>"$book->title Buku berhasil dihapus"
        ]);
        $book->delete();
        return redirect()->route('buku.index');
    }
    public function borrow($id)
    {
        try {
            $book = Book::findOrFail($id);
            Auth::user()->borrow($book);
            Session::flash("flash_notification", [
                "level"=>"success",
                "message"=>"Berhasil meminjam $book->title"
            ]);
        }catch(BookException $e) {
            Session::flash("flash_notification", [
            "level" => "danger",
            "message" => $e->getMessage()
        ]);
        }catch (ModelNotFoundException $e) {
            Session::flash("flash_notification", [
                "level"=>"danger",
                "message"=>"Buku tidak ditemukan."
            ]);
        }
        return redirect('/');
    }
    public function returnBack($book_id)
    {
        $borrowLog = BorrowLog::where('user_id', Auth::user()->id)->where('book_id', $book_id)->where('is_returned', 0)->first();
        if ($borrowLog) {
            $borrowLog->is_returned = true;
            $borrowLog->save();
            Session::flash("flash_notification", [
                "level" => "success",
                "message" => "Berhasil mengembalikan " . $borrowLog->book->title
            ]);
        }
        return redirect('/home');
    }
    public function export() {
        return view('books.export');
    }
    public function exportPost(Request $request) {
        // validasi
        $this->validate($request, [
            'author_id'=>'required',
            'type'=>'required|in:pdf,xls',
            ], [
            'author_id.required'=>'Anda belum memilih penulis. Pilih minimal 1 penulis.'
        ]);
        $books = Book::whereIn('author_id', $request->get('author_id'))->get();
        $handler = 'export' . ucfirst($request->get('type'));
        return $this->$handler($books);
    }
    private function exportXls($books){
        return (new BooksExport)->penulis($books)->download('Buku.xlsx');
    }
    private function exportPdf($books)
    {
        $pdf = PDF::loadview('pdf.books', compact('books'));
        return $pdf->download('books.pdf');
    }

}