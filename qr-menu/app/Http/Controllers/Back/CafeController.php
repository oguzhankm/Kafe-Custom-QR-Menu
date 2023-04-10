<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CafeController extends Controller
{
    /**
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('back.cafe', [
            'cafes' => Cafe::all()
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function show(Request $request)
    {
        try {
            $request->validate(
                [
                    'cafeId' => 'required|numeric'
                ],
                [
                    'cafeId.required' => 'KafeID değeri zorunludur',
                    'cafeId.numeric' => 'KafeID değeri sayısal olmak zorundadır.'
                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        try {
            $cafe = Cafe::findOrFail($request->input('cafeId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kafe bulunamadı!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Kafe bilgileri başarıyla getirildi',
            'cafe' => $cafe
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'title' => 'required',
                    'description' => 'required',
                    'file' => 'file|image'
                ],
                [
                    'title.required' => 'Kafe adı zorunludur!',
                    'description.required' => 'Kafe açıklaması zorunludur!',
                    'file.file' => 'Dosya alanı bir dosya olmalıdır.',
                    'file.image' => 'Dosya alanındaki dosya bir resim olmalıdır',

                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        try {
            $cafeInf = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ];

            if ($request->hasFile('file')) {
                $cafeInf['logo'] = Storage::disk('public')->put('cafe', $request->file('file'));
            }

            $cafe = Cafe::create($cafeInf);

        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kafe oluşturulurken bir sorunla karşılaşıldı!',
                'err' => $exception->getMessage()
            ];
        }

        return [
            'status' => true,
            'msg' => 'Kafe başarıyla eklendi!',
            'cafe' => $cafe
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function update(Request $request)
    {
        try {
            $rules = [
                'cafeId' => 'required'
            ];
            $messages = [
                'cafeId.required' => 'Kafe kimlik bilgisi alanı zorunludur.'
            ];

            if ($request->has('title')) {
                $rules['title'] = 'required';
                $messages['title.required'] = 'Kafe adı zorunludur!';
            }

            if ($request->has('description')) {
                $rules['description'] = 'required';
                $messages['description.required'] = 'Kafe açıklaması zorunludur!';
            }

            if ($request->hasFile('file')) {
                $rules['file'] = 'file|image';
                $messages['file.file'] = 'Dosya alanı bir dosya olmalıdır.';
                $messages['file.image'] = 'Dosya alanındaki dosya bir resim olmalıdır';
            }

            $request->validate($rules, $messages);
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        try {
            $cafe = Cafe::findOrFail($request->post('cafeId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kafe bulunamadı!'
            ];
        }

        try {
            $logoPath = $cafe->logo;
            if ($request->hasFile('file')) {
                $logoPath = Storage::disk('public')->put('cafe', $request->file('file'));
            }

            $cafe->update([
                'title' => $request->has('title') ? $request->post('title') : $cafe->title,
                'description' => $request->has('description') ? $request->post('description') : $cafe->description,
                'logo' => $logoPath
            ]);
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kafe güncellenirken bir sorun oluştu!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Kafe başarıyla güncellendi!',
            'cafe' => $cafe
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function delete(Request $request)
    {
        try {
            $request->validate(
                [
                    'cafeId' => 'required|numeric'
                ],
                [
                    'cafeId.required' => 'KafeID alanı zorunludur!',
                    'cafeId.numeric' => 'KafeID değeri sayısal olmalıdır',
                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        try {
            $cafe = Cafe::findOrFail($request->input('cafeId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kafe bulunamadı!'
            ];
        }

        try {
            Storage::disk('public')->delete($cafe->logo);
            $cafe->delete();

        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kafe silinirken bir sorun oluştu!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Kafe başarıyla silindi!',

        ];
    }
}
