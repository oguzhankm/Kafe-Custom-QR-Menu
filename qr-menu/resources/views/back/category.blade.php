@extends('_layout.back.default')
@section('pageTitle','Yönetim Kategoriler')

@section('foottags')
    <!-- Kategori createOrUpdateModal -->
    <div class="modal fade" id="createOrUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kategori Bilgileri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row mb-3">
                            <label for="name">Kategori Adı</label>
                            <input type="text" id="categoryName" class="form-control" placeholder="Kategori adı..">
                        </div>
                        <div class="form-row mb-3 w-block">
                            <select class="selectpicker form-control" id="selectCafeId" title="Kafe Seçin"
                                    data-live-search="true" multiple>
                                @foreach($cafes as $cafe)
                                    <option value="{{$cafe->id}}">
                                        {{$cafe->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row mb-3">
                            <label for="name">Kategori Logo</label>
                            <input type="file" id="logoInput" class="form-control">
                            <img
                                id="categoryImagePreview"
                                style="display: none"
                                class="mt-3"
                                src=""
                                alt="category_logo" width="200"
                            >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="categoryId" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn btn-primary modalSubmitBtn">Kaydet</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let categoryId, name, selectedCafeId, logoFile;
            let createOrUpdateModal = $('#createOrUpdateModal');
            let categoryIdInput = $('#categoryId');
            let cafeSelect = $('.selectpicker');

            $('.addNewCategory').on('click', function () {
                $('#categoryImagePreview').hide()
                $('#categoryImagePreview').prop('src', "")
                categoryIdInput.val("")
                $('#categoryName').val("");

                cafeSelect.find('option[class="bs-title-option"]').remove()
                cafeSelect.selectpicker('destroy')
                cafeSelect.prop('multiple', true)
                cafeSelect.selectpicker()
                cafeSelect.selectpicker('deselectAll')
                cafeSelect.selectpicker('refresh')

                createOrUpdateModal.modal('show');
            })

            $('.modalSubmitBtn').on('click', function () {
                let fd = new FormData();
                let logoInput = $('#logoInput')

                categoryId = categoryIdInput.val();
                name = $('#categoryName').val();
                selectedCafeId = $('#selectCafeId').selectpicker('val');

                logoFile = document.getElementById('logoInput').files[0];

                fd.append('name', name);
                fd.append('cafeIds', selectedCafeId)

                if (categoryId.length > 0) {
                    // update işlemi yapılıyor.
                    if (logoInput.val().length > 0) {
                        fd.append('file', logoFile);
                    }
                    fd.append('categoryId', categoryId)

                    $.ajax({
                        type: 'POST',
                        url: '{{route('panel.categories.update')}}',
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
                            Toastr.error('Kategori güncellenirken bir sorun oluştu!')
                        }
                    })
                } else {
                    if (logoInput.val().length > 0) {
                        fd.append('file', logoFile);
                    }

                    // create işlemi yapılıyor
                    $.ajax({
                        type: 'POST',
                        url: '{{route('panel.categories.store')}}',
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
                            Toastr.error('Kategori eklenirken bir sorun oluştu!')
                        }
                    })
                }
            });

            //Silme işlemi yapılıyor
            $('.categoryDelete').on('click', function () {
                categoryId = $(this).data('categoryid')

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
                            url: '{{ route('panel.categories.delete') }}',
                            contentType: 'application/json',
                            data: JSON.stringify({categoryId}),
                            success: function (response) {
                                if (response.status) {
                                    Toastr.success(response.msg)
                                    location.reload()
                                } else {
                                    Toastr.error(response.msg)
                                }
                            },
                            error: function (err) {
                                Toastr.error('Kategori silinirken bir sorun oldu!')
                            }
                        })

                    }
                })
            })

            //Update işlemi yapılıyor
            $('.categoryEdit').on('click', function () {
                categoryId = $(this).data('categoryid')
                cafeSelect.selectpicker('destroy')
                cafeSelect.removeAttr('multiple')
                cafeSelect.selectpicker()

                $.ajax({
                    type: 'GET',
                    url: '{{ route('panel.categories.show') }}',
                    data: {categoryId},
                    success: function (response) {
                        if (response.status) {
                            categoryIdInput.val(categoryId)

                            $('#categoryName').val(response.category.name);
                            cafeSelect.selectpicker('val', response.category.cafe_id)

                            if (response.category.logo.length > 0) {
                                $('#categoryImagePreview').show()
                                $('#categoryImagePreview').prop('src', '/storage/' + response.category.logo)
                            } else {
                                $('#categoryImagePreview').hide()
                                $('#categoryImagePreview').prop('src', "")
                            }

                            createOrUpdateModal.modal('show')
                        } else {
                            Toastr.error(response.msg)
                        }
                    },
                    error: function (err) {
                        Toastr.error('Kategori bilgileri getirilirken bir sorun oluştu!')
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
            <h6 class="m-0 font-weight-bold text-primary">Kategorilerim</h6>
            <button class="btn btn-success btn-sm addNewCategory"><i class="fa fa-plus"></i> Yeni Kategori Ekle</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Menu Adresi</th>
                        <th>Kafe Adı</th>
                        <th>Logo</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Başlık</th>
                        <th>Menu Adresi</th>
                        <th>Kafe Adı</th>
                        <th>Logo</th>
                        <th>İşlemler</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                {{ $category->cafes->title }}
                            </td>
                            <td>
                                @if($category->id)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($category->logo) }}"
                                         alt="category_logo" width="150">
                                @endif
                            </td>
                            <td>
                                <span data-categoryid="{{ $category->id }}" class="btn btn-warning btn-sm categoryEdit"><i
                                        class="fa fa-pen"></i></span>
                                <span data-categoryid="{{ $category->id }}"
                                      class="btn btn-danger btn-sm categoryDelete"><i
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
