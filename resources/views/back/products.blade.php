@extends('_layout.back.default')
@section('pageTitle','Yönetim Ürünler')

@section('foottags')
    <!-- Ürün(Product) createOrUpdateModal -->
    <div class="modal fade" id="createOrUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ürün Bilgileri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row mb-3">
                            <label for="name">Ürün Adı</label>
                            <input type="text" id="productName" class="form-control" placeholder="Ürün adı..">
                        </div>
                        <div class="form-row mb-3">
                            <label for="name">Ürün Açıklaması</label>
                            <input type="text" id="productDescription" class="form-control"
                                   placeholder="Ürün Açıklaması..">
                        </div>
                        <div class="form-row mb-3 w-block">
                            <select class="selectpicker form-control" id="selectCategoryId" title="Kategori Seçin"
                                    data-live-search="true" multiple>
                                //controller yapıldıktan sonra değiştirilecek->
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row mb-3">
                            <label for="name">Ürün Resmi</label>
                            <input type="file" id="photoInput" class="form-control">
                            <img
                                id="productImagePreview"
                                style="display: none"
                                class="mt-3"
                                src=""
                                alt="product_photo" width="200"
                            >
                        </div>
                        <div class="form-row mb-3">
                            <label for="name">Ürün Fiyatı</label>
                            <input type="number" id="productPrice" class="form-control" placeholder="Ürün Fiyatı..">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="productId" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn btn-primary modalSubmitBtn">Kaydet</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let productId, name, description, selectedCategoryId, photoFile, price;
            let createOrUpdateModal = $('#createOrUpdateModal');
            let productIdInput = $('#productId');
            let categorySelect = $('.selectpicker');

            $('.addNewProduct').on('click', function () {
                $('#productImagePreview').hide()
                $('#productImagePreview').prop('src', "")
                productIdInput.val("")
                $('#productName').val("");

                categorySelect.find('option[class="bs-title-option"]').remove()
                categorySelect.selectpicker('destroy')
                categorySelect.prop('multiple', true)
                categorySelect.selectpicker()
                categorySelect.selectpicker('deselectAll')
                categorySelect.selectpicker('refresh')

                createOrUpdateModal.modal('show');
            })

            $('.modalSubmitBtn').on('click', function () {
                let fd = new FormData();
                let photoInput = $('#photoInput');

                productId = productIdInput.val();
                name = $('#productName').val();
                description = $('#productDescription').val();
                selectedCategoryId = $('#selectCategoryId').selectpicker('val');
                price = $('#productPrice').val();

                photoFile = document.getElementById('photoInput').files[0];

                fd.append('name', name);
                fd.append('description', description);
                fd.append('price', price);
                fd.append('categoryIds', selectedCategoryId)

                if (productId.length > 0) {
                    // update işlemi yapılıyor.
                    if (photoInput.val().length > 0) {
                        fd.append('file', photoFile);
                    }
                    fd.append('productId', productId)

                    $.ajax({
                        type: 'POST',
                        url: '{{route('panel.products.update')}}',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.status) {
                                Toastr.success(response.msg)
                                location.reload()
                            } else {
                                Toastr.error(response.msg)
                            }
                        },
                        error: function (err) {
                            Toastr.error('Ürün güncellenirken bir sorun oluştu!')
                        }
                    })
                } else {
                    if (photoInput.val().length > 0) {
                        fd.append('file', photoFile);
                    }

                    // store(create) işlemi yapılıyor
                    $.ajax({
                        type: 'POST',
                        url: '{{route('panel.products.store')}}',
                        data: fd,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.status) {
                                Toastr.success(response.msg)
                                location.reload()
                            } else {
                                Toastr.error(response.msg)
                            }
                        },
                        error: function (err) {
                            Toastr.error('Ürün eklenirken bir sorun oluştu!')
                        }
                    })
                }
            });

            //Silme işlemi yapılıyor
            $('.productDelete').on('click', function () {
                productId = $(this).data('productid')

                Swal.fire({
                    title: 'Emin misin?',
                    text: "Bu işlemi geri alamazsın!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet',
                    cancelButtonText: 'Hayır',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: '{{ route('panel.products.delete') }}',
                            contentType: 'application/json',
                            data: JSON.stringify({productId}),
                            success: function (response) {
                                if (response.status) {
                                    Toastr.success(response.msg)
                                    location.reload()
                                } else {
                                    Toastr.error(response.msg)
                                }
                            },
                            error: function (err) {
                                Toastr.error('Ürün silinirken bir sorun oldu!')
                            }
                        })

                    }
                })
            })

            //Düzenleme işlemi yapılıyor
            $('.productEdit').on('click', function () {
                productId = $(this).data('productid')
                categorySelect.selectpicker('destroy')
                categorySelect.removeAttr('multiple')
                categorySelect.selectpicker()

                $.ajax({
                    type: 'GET',
                    url: '{{ route('panel.products.show') }}',
                    data: {productId},
                    success: function (response) {
                        if (response.status) {
                            productIdInput.val(productId)

                            $('#productName').val(response.product.name);
                            $('#productDescription').val(response.product.name);
                            categorySelect.selectpicker('val', response.product.category_id)

                            if (response.product.photo.length > 0) {
                                $('#productImagePreview').show()
                                $('#productImagePreview').prop('src', '/storage/' + response.product.photo)
                            } else {
                                $('#productImagePreview').hide()
                                $('#productImagePreview').prop('src', "")
                            }
                            $('#productPrice').val(response.product.price);
                            createOrUpdateModal.modal('show')
                        } else {
                            Toastr.error(response.msg)
                        }
                    },
                    error: function (err) {
                        Toastr.error('Ürün bilgileri getirilirken bir sorun oluştu!')
                    }
                })
            })
        })
    </script>

@endsection

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Ürünlerim</h6>
            <button class="btn btn-success btn-sm addNewProduct"><i class="fa fa-plus"></i> Yeni Ürün Ekle</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Ürün Adresi</th>
                        <th>Kategori Adı</th>
                        <th>Ürün Açıklaması</th>
                        <th>Resim</th>
                        <th>Fiyatı</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Başlık</th>
                        <th>Ürün Adresi</th>
                        <th>Ürün Açıklaması</th>
                        <th>Kategori Adı</th>
                        <th>Resim</th>
                        <th>Fiyatı</th>
                        <th>İşlemler</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->slug }}</td>
                            <td>
                                {{ $product->category->name }}
                            </td>
                            <td>{{ $product->description }}</td>
                            <td>
                                @if($product->id)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($product->photo) }}"
                                         alt="product_photo" width="150">
                                @endif
                            </td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <span data-productid="{{ $product->id }}" class="btn btn-warning btn-sm productEdit"><i
                                        class="fa fa-pen"></i></span>
                                <span data-productid="{{ $product->id }}"
                                      class="btn btn-danger btn-sm productDelete"><i
                                        class="fa fa-trash"></i></span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
