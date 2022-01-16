<?php

namespace App\Reports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
// use Maatwebsite\Excel\Concerns\WithStyles;

class SaleExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $sales;

    public function __construct($sales)
    {
        $this->sales = $sales;
    }

    public function array(): array
    {
        return $this->sales->toArray();
    }

    public function headings(): array
    {
        return [
            'full_name', 'identification_type', 'identification_number', 'phone', 'subtotal', 'total', 'state', 'created_at'
        ];
    }
}
