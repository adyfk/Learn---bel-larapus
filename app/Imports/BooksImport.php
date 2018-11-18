<?php

namespace App\Imports;

use App\Book;
use App\Author;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class BooksImport implements ToModel,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function headingRow(): int
    {
        return 1;
    }
    public function model(array $row)
    {
        $x;
        if(is_int($row['id_author']) ){
            $x=$row['id_author'];
        }else{
            $x=Author::where('name',$row['id_author'])->first();   
        }
        $book1 = Book::create(['title'=>$row['buku'],'author_id'=>$x->id, 'amount'=>$row['jumlah']]);
        return $book1;
    }
}