<?php

namespace App\Exports;

use App\City;
use App\Request;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RequestsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $collection = new Request();
        if (request()->filled('name')) {

            $users_id = User::where('type', 'user')->where('name', 'LIKE', '%' . request()->get('name') . '%')->pluck('id');
            $collection = $collection->whereIn('user_id', $users_id);
        }

        if (request()->filled('city')) {
            $cities_id = City::where('name', 'LIKE', '%' . request()->get('city') . '%')->pluck('id');
            $collection = $collection->whereIn('city_id', $cities_id);
        }


        if (request()->filled('type')) {
            $collection = $collection->where('type', request()->get('type'));
        }
        if (request()->filled('service_id')) {
            $collection = $collection->where('service_id', request()->get('service_id'));
        }
        if (request()->filled('status')) {
            $collection = $collection->where('status', request()->get('status'));
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
            'رقم الطلب',
            'مقدم الطلب',
            'المدينة',
            'نوع الخدمة',
            'الخدمة',
            'التواصل المفضلة',
            'الدفع المفضلة',
            'تاريخ الخدمة',
            'حالة الطلب',
            'تفاصيل الطلب',
            'الاثباتات و الأدلة',
            'النتائج',
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
            $row->User->name,
            isset($row->City) ? $row->City->name : '',
            ($row->type == 'categorized') ? 'مصنّفة' : 'غير مصنّفة',
            isset($row->Service) ? $row->Service->name : '',
            isset($row->contact_prefer) ? __('app.contact_prefer.' . $row->contact_prefer) : '',
            isset($row->payment_prefer) ? __('app.payment_prefer.' . $row->payment_prefer) : '',
            $row->service_date,
            __('app.order_statuses.' . $row->status),
            $row->case_text,
            $row->evidences_text,
            $row->preferred_outcomes_text,
        ];
    }
}
