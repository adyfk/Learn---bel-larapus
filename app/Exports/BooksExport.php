<?php

namespace App\Exports;

use App\Book;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style;
use Maatwebsite\Excel\Concerns\FromCollection;
class BooksExport implements FromQuery,WithHeadings,WithColumnFormatting,FromCollection
{
    use Exportable;
    public function penulis($penulis)
    {
        $this->penulis = $penulis;   
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
    public function query()
    {
        return Book::with('author')->whereIn('author_id',$this->penulis)->get();
       // return Book::query()->whereIn('id',$this->penulis) ;
    }
    public function collection()
    {
        $x = $this->query();
        foreach($x as $y){
            $data[] = [$y->id,$y->title,$y->author->name,$y->amount,$y->created_at,$y->updated_at];
        }
        return collect($data);
        
    }
}
//https://www.youtube.com/watch?v=LWLN4p7Cn4E
