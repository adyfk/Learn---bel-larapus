<?php

namespace App\Exports;

use App\Book;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style;
use Maatwebsite\Excel\Concerns\FromCollection;
class BooksExport implements WithHeadings,WithColumnFormatting,FromCollection
{
    use Exportable;
    public function penulis($book)
    {
        $this->book = $book;   
        return $this;
    }
    public function headings(): array
    {
        return [
            'No', 'Buku', 'Id_Author','Jumlah','Input','Update'
        ];
    }
    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER,
            'E' => NumberFormat::FORMAT_DATE_YYYYMMDD,
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD
        ];
    }
    public function collection()
    {
        $x = $this->book;
        foreach($x as $y){
            $data[] = [$y->id,$y->title,$y->author->name,$y->amount,$y->created_at,$y->updated_at];
        }
        return collect($data);
        
    }
}
//https://www.youtube.com/watch?v=LWLN4p7Cn4E
