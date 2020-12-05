<?php

namespace App\Exports\Constant;

use App\ServiceProviderType;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServiceProviderTypesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = new ServiceProviderType();

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
            'نوع مزود الخدمة',
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
