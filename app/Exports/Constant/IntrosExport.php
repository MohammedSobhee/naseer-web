<?php

namespace App\Exports\Constant;

use App\Intro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IntrosExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = new Intro();

        if (request()->filled('title')) {
            $collection = $collection->where('title', 'LIKE', '%' . request()->get('title') . '%');
        }
        return $collection->get();
    }


    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '#',
            'العنوان',
            'النص',
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
            $row->title,
            $row->description,
        ];
    }
}
