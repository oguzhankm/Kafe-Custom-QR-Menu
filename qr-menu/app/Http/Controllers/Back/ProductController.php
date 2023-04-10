<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $products = Product::query()->with('category')->get();

        return view('back.products', [
            'products' => $products,
            'categories' => Category::all()
        ]);
    }

    /**
     * @throws Exception
     */
    public function store(Request $request)
    {
        //Kategori validatition işlemleri başlangıç
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required|max:250',
                'price' => 'required|numeric',
                'file' => 'required|image'
            ],
                [
                    'name.required' => 'ürün adı zorunludur!',
                    'description.required' => 'Ürün açıklaması zorunludur!',
                    'price.required' => 'Ürün fiyatı girilmesi zorunludur!',
                    'file.required' => 'Dosya alanı dosya olmalıdır!',
                    'file.image' => 'Dosya alanında ki dosya bir resim olmalıdır!',
                ]);

            $categoryIds = explode(',', $request->post('categoryIds'));
            foreach ($categoryIds as $categoryId) {
                try {
                    Category::findOrFail($categoryId);
                } catch (Throwable $exception) {
                    throw new Exception('Kategori bulunamadı!');
                }
            }
        } catch (ValidationException $exception) {
            return \response()->json([
                'status ' => false,
                'msg' => $exception->getMessage()
            ]);
        }
        // Validation işlemleri bitiş


        try {
            $productInf = [
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
            ];

            if ($request->hasFile('file')) {
                $productInf['photo'] = Storage::disk('public')->put('products', $request->file('file'));
            }


            $createdProducts = [];
            foreach ($categoryIds as $categoryId) {
                $productInf['category_id'] = $categoryId;

                $createdProducts[] = Product::create($productInf);
            }
        } catch (Throwable $exception) {
            return \response()->json([
                'status' => false,
                'msg' => 'Ürün oluşturulurken bir hata ile karşılaşıldı',
                'err' => $exception->getMessage()
            ]);
        }


        return \response()->json([
            'status' => true,
            'msg' => 'Ürün başarılı şekilde oluşturuldu',
            'products' => $createdProducts
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
                    'productId' => 'required|numeric'
                ],
                [
                    'productId.required' => 'Ürün ID değeri zorunludur',
                    'productId.numeric' => 'Ürün ID değeri sayısal olmak zorundadır.'
                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        try {
            $product = Product::findOrFail($request->input('productId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Ürün bulunamadı!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Ürün bilgileri başarıyla getirildi',
            'product' => $product
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
                'productId' => 'required'
            ];
            $messages = [
                'productId.required' => 'Ürün kimlik bilgisi alanı zorunludur.'
            ];

            if ($request->has('name')) {
                $rules['name'] = 'required';
                $messages['name.required'] = 'Ürün adı zorunludur!';
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
            $product = Product::findOrFail($request->post('productId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Ürün bulunamadı!'
            ];
        }

        try {
            Product::findOrFail($request->post('productId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Ürün bulunamadı!'
            ];
        }

        try {
            $photoPath = $product->photo;
            if ($request->hasFile('file')) {
                $photoPath = Storage::disk('public')->put('products', $request->file('file'));
            }

            $product->update([
                'name' => $request->has('name') ? $request->post('name') : $product->name,
                'description' => $request->has('description') ? $request->post('description') : $product->description,
                'category_id' => $request->has('categoryIds') ? $request->post('categoryIds') : $product->category_id,
                'photo' => $photoPath,
                'price' => $request->has('price') ? $request->post('price') : $product->price,
            ]);
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Ürün güncellenirken bir sorun oluştu!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Ürün başarıyla güncellendi!',
            'product' => $product
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
                    'productId' => 'required|numeric'
                ],
                [
                    'productId.required' => 'Ürün ID alanı zorunludur!',
                    'productId.numeric' => 'Ürün ID değeri sayısal olmalıdır',
                ]
            );
        } catch (ValidationException $exception) {
            return [
                'status' => false,
                'msg' => $exception->getMessage()
            ];
        }

        try {
            $product = Product::findOrFail($request->input('productId'));
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Ürün bulunamadı!'
            ];
        }

        try {
            $product->delete();
        } catch (\Throwable $exception) {
            return [
                'status' => false,
                'msg' => 'Ürün silinirken bir sorun oluştu!'
            ];
        }

        return [
            'status' => true,
            'msg' => 'Ürün başarıyla silindi!',
        ];
    }
}
