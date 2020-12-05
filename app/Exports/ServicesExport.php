<?php

namespace App\Exports;

use App\Service;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServicesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = new Service();

        if (request()->filled('service_provider_type_id')) {
            $collection = $collection->where('service_provider_type_id', request()->get('service_provider_type_id'));
        }
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
            'الخدمة',
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
            $row->ServiceProviderType->name,
        ];
    }
}
