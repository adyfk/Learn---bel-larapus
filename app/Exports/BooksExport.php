<?php

namespace App\Exports;

use App\Book;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class BooksExport implements FromQuery
{
    use Exportable;
    public function penulis($penulis)
    {
        $this->penulis = $penulis;   
        return $this;
    }
    public function query()
    {
        return Book::query()->whereIn('id',$this->penulis);
    }
}
