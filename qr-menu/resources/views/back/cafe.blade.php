@extends('_layout.back.default')
@section('pageTitle','Yönetim Kafeler')

@section('foottags')
    <!-- Kafe createOrUpdateModal -->
    <div class="modal fade" id="createOrUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kafe Bilgileri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-row mb-3">
                            <label for="name">Kafe Adı</label>
                            <input type="text" id="cafeName" class="form-control" placeholder="kafe adı..">
                        </div>
                        <div class="form-row mb-3">
                            <label for="name">Kafe Açıklaması</label>
                            <input type="text" id="cafeDescription" class="form-control" placeholder="kafe adı..">
                        </div>
                        <div class="form-row mb-3">
                            <label for="name">Kafe Logo</label>
                            <input type="file" id="logoInput" class="form-control">
                            <img
                                id="cafeImagePreview"
                                style="display: none"
                                class="mt-3"
                                src=""
                                alt="cafe_logo" width="200"
                            >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="cafeId" value="">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                    <button type="button" class="btn btn-primary modalSubmitBtn">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script>
        $(document).ready(function () {
            let cafeId, title, description, logoFile;
            let createOrUpdateModal = $('#createOrUpdateModal')
            let cafeIdInput = $('#cafeId')

            $('.addNewCafe').on('click', function () {
                $('#cafeImagePreview').hide()
                $('#cafeImagePreview').prop('src', "")
                $('#cafeName').val("");
                $('#cafeDescription').val("");
                cafeIdInput.val("")
                createOrUpdateModal.modal('show');
            })

            $('.modalSubmitBtn').on('click', function () {
                let fd = new FormData();
                let logoInput = $('#logoInput')

                cafeId = cafeIdInput.val();
                title = $('#cafeName').val();
                description = $('#cafeDescription').val();
                logoFile = document.getElementById('logoInput').files[0];

                fd.append('title', title);
                fd.append('description', description);

                if (cafeId.length > 0) {
                    // update işlemi
                    if (logoInput.val().length > 0) {
                        fd.append('file', logoFile);
                    }
                    fd.append('cafeId', cafeId)

                    $.ajax({
                        type: 'POST',
                        url: '{{route('panel.cafe.update')}}',
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
                            Toastr.error('Kafe güncellenirken bir sorun oluştu!')
                        }
                    })
                } else {
                    if (logoInput.val().length > 0) {
                        fd.append('file', logoFile);
                    }

                    // create işlemi yapılıyor
                    $.ajax({
                        type: 'POST',
                        url: '{{route('panel.cafe.store')}}',
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
                            Toastr.error('Kafe eklenirken bir sorun oluştu!')
                        }
                    })
                }
            });

            //Silme işlemi yapılıyor
            $('.cafeDelete').on('click', function () {
                cafeId = $(this).data('cafeid')

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
                            url: '{{ route('panel.cafe.delete') }}',
                            contentType: 'application/json',
                            data: JSON.stringify({cafeId}),
                            success: function (response) {
                                if (response.status) {
                                    Toastr.success(response.msg)
                                    location.reload()
                                } else {
                                    Toastr.error(response.msg)
                                }
                            },
                            error: function (err) {
                                Toastr.error('Kafe silinirken bir sorun oldu!')
                            }
                        })

                    }
                })
            })

            //Update işlemi yapılıyor
            $('.cafeEdit').on('click', function () {
                cafeId = $(this).data('cafeid')

                $.ajax({
                    type: 'GET',
                    url: '{{ route('panel.cafe.show') }}',
                    data: {cafeId},
                    success: function (response) {
                        if (response.status) {
                            cafeIdInput.val(cafeId)

                            $('#cafeName').val(response.cafe.title);
                            $('#cafeDescription').val(response.cafe.description);

                            if (response.cafe.logo.length > 0) {
                                $('#cafeImagePreview').show()
                                $('#cafeImagePreview').prop('src', '/storage/' + response.cafe.logo)
                            } else {
                                $('#cafeImagePreview').hide()
                                $('#cafeImagePreview').prop('src', "")
                            }

                            createOrUpdateModal.modal('show')
                        } else {
                            Toastr.error(response.msg)
                        }
                    },
                    error: function (err) {
                        Toastr.error('Kafe bilgileri getirilirken bir sorun oluştu!')
                    }
                })
            })
        })
    </script>
    <script>
        //QR Kod ekleme işlemi
        $(document).ready(function () {
            @foreach($cafes as $cafe)
            $('#qrcode{{$cafe->id}}').qrcode({
                width: 112,
                height: 112,
                text: "{{ route('cafe.menu',['cafe'=>$cafe->slug]) }}"
            });
            @endforeach
        })
    </script>
@endsection

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Kafelerim</h6>
            <button class="btn btn-success btn-sm addNewCafe"><i class="fa fa-plus"></i> Yeni Kafe Ekle</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Menu Adresi</th>
                        <th>Logo</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Başlık</th>
                        <th>Açıklama</th>
                        <th>Menu Adresi</th>
                        <th>Logo</th>
                        <th>İşlemler</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    @foreach($cafes as $cafe)
                        <tr>
                            <td>{{ $cafe->title }}</td>
                            <td>{{ $cafe->description }}</td>
                            <td>
                                <div id="qrcode{{$cafe->id}}"></div>
                            </td>
                            <td>
                                @if($cafe->logo)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($cafe->logo) }}"
                                         alt="cafe_logo" width="150">
                                @endif
                            </td>
                            <td>
                                <span data-cafeid="{{ $cafe->id }}" class="btn btn-warning btn-sm cafeEdit"><i
                                        class="fa fa-pen"></i></span>
                                <span data-cafeid="{{ $cafe->id }}" class="btn btn-danger btn-sm cafeDelete"><i
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
