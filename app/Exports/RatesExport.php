<?php

namespace App\Exports;

use App\Rate;
use App\Request;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RatesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $collection = new Rate();
        if (request()->filled('name')) {
            $users_id = User::where('type', 'user')->where('name', 'LIKE', '%' . request()->get('name') . '%')->pluck('id');
            $collection = $collection->whereIn('user_id', $users_id);
        }
        if (request()->filled('service_provider')) {
            $service_provider_id = User::where('type', 'service_provider')->where('name', 'LIKE', '%' . request()->get('service_provider') . '%')->pluck('id');
            $collection = $collection->whereIn('service_provider_id', $service_provider_id);
        }
        if (request()->filled('type')) {
            $request_id = Request::where('type', request()->get('type'))->pluck('id');
            $collection = $collection->whereIn('request_id', $request_id);

        }
        if (request()->filled('service_id')) {
            $request_id = Request::where('service_id', request()->get('service_id'))->pluck('id');
            $collection = $collection->whereIn('request_id', $request_id);

        }
        if (request()->filled('is_approved')) {
            $collection = $collection->where('is_approved', request()->get('is_approved'));
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
            'رقم التقييم',
            'مقدم الطلب',
            'مزود الخدمة',
            'نوع الخدمة',
            'الخدمة',
            'التقييم',
            'نص التقييم',
            'الاعتمادية',
        ];
    }

    /**
     * @inheritDoc
     * `user_id`, `service_provider_id`, `request_id`, `rate`, `note`, `is_approved`
     */
    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->id,
            $row->Client->name,
            $row->ServiceProvider->name,
            isset($row->Order->Service) ? $row->Order->Service->name : '',
            ($row->Order->type == 'categorized') ? 'مصنّفة' : 'غير مصنّفة',
            $row->rate,
            $row->note,
            ($row->is_approved) ? 'معتمد' : 'غير معتمد',
        ];
    }
}
