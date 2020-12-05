<?php

namespace App\Exports\Constant;

use App\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CountriesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = new Country();

        if (request()->filled('name')) {
            $collection = $collection->where('name', 'LIKE', '%' . request()->get('name') . '%');
        }
        return $collection->get();
    }


    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '#',
            'الدولة',
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->id,
            $row->name,
        ];
    }
}
