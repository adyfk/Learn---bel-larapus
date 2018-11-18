<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
class Template implements WithHeadings
{
    use Exportable;
    public function headings(): array
    {
        return [
            'Buku', 'Id_Author','Jumlah'
        ];
    }
}
