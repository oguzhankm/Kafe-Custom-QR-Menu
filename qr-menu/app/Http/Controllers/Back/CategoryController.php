<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class CategoryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('back.category', [
            'categories' => Category::with('cafes')->get(),
            'cafes' => Cafe::all()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function store(Request $request)
    {
        try {
            $request->validate(
                [
                    'name' => 'required',
                    'file' => 'required|image',
                ],
                [
                    'name.required' => 'Kategori adı zorunludur!',
                    'file.required' => 'Dosya alanı dosya olmalıdır!',
                    'file.image' => 'Dosya alanında ki dosya bir resim olmalıdır!',
                ]
            );

            $cafeIds = explode(',', $request->post('cafeIds'));

            foreach ($cafeIds as $cafeId) {
                try {
                    Cafe::findOrFail($cafeId);
                } catch (Throwable $exception) {
                    throw new Exception('Kafe bulunamadı!');
                }
            }
        } catch (ValidationException $exception) {
            return \response()->json([
                'status ' => false,
                'msg' => $exception->getMessage()
            ]);
        }


        try {
            $categoryInf = [
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
            ];

            if ($request->hasFile('file')) {
                $categoryInf['logo'] = Storage::disk('public')->put('category', $request->file('file'));
            }


            $createdCategories = [];
            foreach ($cafeIds as $cafeId) {
                $categoryInf['cafe_id'] = $cafeId;

                $createdCategories[] = Category::create($categoryInf);
            }
        } catch (Throwable $exception) {
            return \response()->json([
                'status' => false,
                'msg' => 'Kategori oluşturulurken bir hata ile karşılaşıldı',
                'err' => $exception->getMessage()
            ]);
        }


        return \response()->json([
            'status' => true,
            'msg' => 'Kategori başarılı şekilde oluşturuldu',
            'categories' => $createdCategories,
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
                    'categoryId' => 'required|numeric'
                ],
                [
                    'categoryId.required' => 'Kategori ID değeri zorunludur',
                    'categoryId.numeric' => 'Kategori ID değeri sayısal olmak zorundadır.'
                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        try {
            $category = Category::findOrFail($request->input('categoryId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kategori bulunamadı!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Kategori bilgileri başarıyla getirildi',
            'category' => $category
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
                'categoryId' => 'required'
            ];
            $messages = [
                'categoryId.required' => 'Kategori kimlik bilgisi alanı zorunludur.'
            ];

            if ($request->has('name')) {
                $rules['name'] = 'required';
                $messages['name.required'] = 'Kategori adı zorunludur!';
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
            $category = Category::findOrFail($request->post('categoryId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kategori bulunamadı!'
            ];
        }

        try {
            Cafe::findOrFail($request->post('cafeIds'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kafe bulunamadı!'
            ];
        }

        try {
            $logoPath = $category->logo;
            if ($request->hasFile('file')) {
                $logoPath = Storage::disk('public')->put('cafe', $request->file('file'));
            }

            $category->update([
                'name' => $request->has('name') ? $request->post('name') : $category->name,
                'cafe_id' => $request->has('cafeIds') ? $request->post('cafeIds') : $category->cafe_id,
                'logo' => $logoPath
            ]);
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kategori güncellenirken bir sorun oluştu!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Kategori başarıyla güncellendi!',
            'cafe' => $category
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
        try {
            $request->validate(
                [
                    'categoryId' => 'required|numeric'
                ],
                [
                    'categoryId.required' => 'Kategori ID alanı zorunludur!',
                    'categoryId.numeric' => 'Kategori ID değeri sayısal olmalıdır',
                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        try {
            $category = Category::findOrFail($request->input('categoryId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kategori bulunamadı!'
            ];
        }

        try {
            $category->delete();
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Kategori silinirken bir sorun oluştu!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Kategori başarıyla silindi!',
        ];
    }
}
