<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Intro\CreateRequest;
use App\Http\Requests\Intro\UpdateRequest;
use App\Intro;
use App\Repositories\Eloquents\IntroEloquent;
use Illuminate\Http\Request;

class IntroController extends Controller
{
    private $intro;

    public function __construct(IntroEloquent $intro)
    {
//        parent::__construct();
        $this->intro = $intro;
    }

    public function index()
    {
        $data = [
            'title' => 'جمل تعريفية',
            'icon' => 'icon-layers',
        ];
        return view(admin_vw() . '.constants.intros', $data);
    }

    public function anyData()
    {
        return $this->intro->anyData();
    }

    public function edit($id)
    {

        $intro = $this->intro->getById($id);

        $html = 'This intro does not exist';
        if (isset($intro)) {
            $view = view()->make(admin_vw() . '.modal', [
                'modal_id' => 'edit-intro',
                'modal_title' => 'تعديل الجمل التعريفية',

                'form' => [
                    'method' => 'PUT',
                    'url' => url(admin_constant_url() . '/intros/' . $id . '/edit'),
                    'form_id' => 'formEdit',

                    'fields' => [
                        'image' => 'image',
                        'title' => 'text',
                        'description' => 'textarea',
                    ],
                    'values' => [
                        'image' => $intro->image,
                        'title' => $intro->title,
                        'description' => $intro->description,

                    ],
                    'fields_ar' => [
                        'image' => 'صورة',
                        'title' => 'عنوان',
                        'description' => 'نص',
                    ]
                ]
            ]);

            $html = $view->render();
        }
        return $html;
    }

    public function update(UpdateRequest $request, $id)
    {
        return $this->intro->update($request->all(), $id);
    }

    public function create()
    {
        $view = view()->make(admin_vw() . '.modal', [
            'modal_id' => 'add-intro',
            'modal_title' => 'اضافة الجمل التعريفية جديد',
            'form' => [
                'method' => 'POST',
                'url' => url(admin_constant_url() . '/intros/create'),
                'form_id' => 'formAdd',
                'fields' => [
                    'image' => 'image',
                    'title' => 'text',
                    'description' => 'textarea',
                ],
                'fields_ar' => [
                    'image' => 'صورة',
                    'title' => 'عنوان',
                    'description' => 'نص',

                ]
            ]
        ]);

        $html = $view->render();

        return $html;
    }

    public function store(CreateRequest $request)
    {
        return $this->intro->create($request->all());
    }

    public function delete($id)
    {

        return $this->intro->delete($id);
    }
}
