<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = new User();

//        if (request()->filled('t')) {
//
//        }

        return $collection->get();
    }

//    `name`, `phone`, `country_code`, `email`, `email_verified_at`,
// `password`, `verification_code`, `is_verify`, `photo`, `gender`,
// `type`, `is_active`, `city_id`, `is_completed`, `is_edit`, `master_id`

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'Name',
            'Phone',
            'Email'
        ];
    }

    /**
     * @inheritDoc
     */
    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->name,
            $row->phone,
            $row->email
        ];
    }
}
