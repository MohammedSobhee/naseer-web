<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ServiceProvidersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = new User();

        if (request()->filled('name')) {
            $collection = $collection->where('name', 'LIKE', '%' . request()->get('name') . '%');
        }
        if (request()->filled('email')) {
            $collection = $collection->where('email', request()->get('email'));
        }
        if (request()->filled('phone')) {
            $collection = $collection->whereRaw('CONCAT(country_code,phone) = ?', request()->get('phone'));
        }
        if (request()->filled('is_verify')) {
            $collection = $collection->where('is_verify', request()->get('is_verify'));
        }
        if (request()->filled('is_active')) {
            $collection = $collection->where('is_active', request()->get('is_active'));
        }
        if (request()->filled('type')) {
            $collection = $collection->where('type', request()->get('type'));
        }
        return $collection->get();
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            '#',
            'اسم المستخدم',
            'رقم الهاتف',
            'البريد الالكتروني',
            'الجنس',
            'كود التحقق',
            'نوع المستخدم',
            'المدينة',
            'العنوان',
            'رقم الهوية',
            'المهارات',
            'نوع الترخيص',
            'الترخيص',
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
            $row->country_code . '' . $row->phone,
            $row->email,
            ($row->gender == 'male') ? 'ذكر' : 'انثى',
            $row->verification_code,
            ($row->type == 'user') ? 'عميل' : 'مزود خدمة',
            isset($row->City) ? $row->City->name : '',
            isset($row->ServiceProvider) ? $row->ServiceProvider->address : '',
            isset($row->ServiceProvider) ? $row->ServiceProvider->idno : '',
            isset($row->ServiceProvider) ? $row->ServiceProvider->skill : '',
            isset($row->ServiceProvider) && ($row->ServiceProvider->license_type == 'licensed') ? 'مرخّص' : 'غير مرخّص',
            isset($row->ServiceProvider) ? $row->ServiceProvider->licensed : '',
            isset($row->ServiceProvider) ? $row->ServiceProvider->ServiceProviderType->name : '',
        ];
    }
}
