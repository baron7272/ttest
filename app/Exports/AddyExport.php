<?php

namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AddyExport implements FromCollection, WithHeadings
{

    private $data;
    private $heading;

    public function __construct($heading, $data)
    {
        $this->data = $data;
        $this->heading = $heading;
    }

    public function collection()
    {
        
        return $this->data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return $this->heading;
    }


}