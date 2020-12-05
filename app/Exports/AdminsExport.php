<?php

namespace App\Exports;

use App\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminsExport implements FromCollection, WithHeadings, WithMapping
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = new Admin();

        if (request()->filled('username')) {
            $collection = $collection->where('username', 'LIKE', '%' . request()->get('username') . '%');
        }
        if (request()->filled('email')) {
            $collection = $collection->where('email', request()->get('email'));
        }

        if (request()->filled('status')) {
            $collection = $collection->where('status', request()->get('status'));
        }
        return $collection->get();
    }

    /**
     * @inheritDoc
     *  `name`, `username`, `phone`, `email`, `password`, `logo`, `type`, `status`
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '#',
            'الاسم كامل',
            'اسم المستخدم',
            'رقم الهاتف',
            'البريد الالكتروني',
            'الحالة',
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
            $row->username,
            $row->phone,
            $row->email,
            ($row->status) ? 'مفعّل' : 'معطّل',
        ];
    }
}
