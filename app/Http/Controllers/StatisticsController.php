<?php

namespace App\Http\Controllers;
use DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\Request;
use App\BorrowLog;

class StatisticsController extends Controller
{
    public function index(Builder $builder)
    {
        if (request()->ajax()){
            $stats = BorrowLog::with('book','user');
            if(request()->get('status') == 'returned') $stats->returned();
            if(request()->get('status') == 'not-returned') $stats->borrowed();
            return DataTables::of($stats)
            ->addColumn('returned_at', function($stat){
                    if ($stat->is_returned){
                        return $stat->updated_at;
                    }
                        return "Masih dipinjam";
                    })->make(true);
                        
        }        
        $html = $builder->columns([
                ['data' => 'book.title', 'name'=>'book.title', 'title'=>'Judul'],
                ['data' => 'user.name', 'name'=>'user.name', 'title'=>'Peminjam'],
                ['data' => 'created_at', 'name'=>'created_at', 'title'=>'Tanggal Pinjam','searchable'=>false],
                ['data' => 'returned_at', 'name'=>'returned_at', 'title'=>'', 'orderable'=>false,'searchable'=>false]
            ]);
        return view('statistic.index', compact('html'));
    }
}
