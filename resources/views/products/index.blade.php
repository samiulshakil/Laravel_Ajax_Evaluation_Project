@extends('layouts.master')

@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: initial;
        }

        .error {
            color: red;
        }
    </style>
@endpush

@section('contents')
    <div class="row">
        <div class="col-md-8">
            <h3 class="mb-5 text-center">All Products</h3>
            <div class="main-card ajax_dynamic mb-3 card">
                @include('partials.all')
            </div>
        </div>
        <div class="col-md-4">
            <h3 class="text-center" id="createP">Create Product</h3>
            <form action="{{ route('products.store') }}" id="formDatas" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="update_id" id="update_id">
                <div class="form-group mb-2">
                    <label for="name" class="col-form-label text-md-end">{{ __('Product Name') }}</label>
                    <input type="text" class="form-control" name="name" id="name" style="border-radius: 5px">
                </div>
                @error('name')
                    <p>
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </p>
                @enderror

                <div class="form-group mb-2">
                    <label for="title" class="col-form-label text-md-end">{{ __('Product Title') }}</label>
                    <input type="text" class="form-control" name="title" id="title" style="border-radius: 5px">
                </div>
                @error('title')
                    <p>
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </p>
                @enderror

                <div class="form-group mb-2">
                    <label for="description" class="col-form-label text-md-end">{{ __('Product Description') }}</label>
                    <input type="text" class="form-control" name="description" id="description"
                        style="border-radius: 5px">
                </div>
                @error('description')
                    <p>
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </p>
                @enderror

                <div class="form-group mb-3">
                    <label for="image" class="mb-2">Select Product Image</label>
                    <input type="file" id="image" data-show-errors="true" data-errors-position="outside"
                        data-allowed-file-extensions="jpg jpeg png svg webp gif"
                        class="dropify form-control @error('image') is-invalid @enderror" name="image">
                    <input type="hidden" name="old_image" id="old_avatar">
                </div>
                @error('image')
                    <p>
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    </p>
                @enderror

                <button type="submit" class="btn btn-primary mb-2 bg-primary">
                    <span id="submitBtn">Create</span>
                </button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(document).on('submit', '#formDatas', function(e) {
                e.preventDefault();
                let formData = new FormData($('#formDatas')[0]);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ route('products.store') }}",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#formDatas').find('.is-invalid').removeClass('is-invalid');
                        $('#formDatas').find('.error').remove();

                        if (response.status == false) {
                            $.each(response.errors, function(key, value) {
                                $('#formDatas #' + key).addClass('is-invalid');
                                $('#formDatas #' + key).parent().append(
                                    '<div class="error d-block">' + value + '</div>'
                                );
                            });
                        } else {
                            flashMessage(response.status, response.message);
                            if (response.status == 'success') {
                                $('#formDatas').find('input').val('');
                                $('.dropify-clear').click();
                                $('.ajax_dynamic').html(response.datas);
                            }
                        }
                    }
                });

            });

            // //edit product data
            // $(document).on('click', '.edit_data', function() {
            //     let id = $(this).data('id');
            //     var url = "{{ route('products.edit', ':id') }}";
            //     url = url.replace(':id', id);

            //     if (id) {
            //         $.ajaxSetup({
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             }
            //         });
            //         $.ajax({
            //             url: url,
            //             type: "get",
            //             dataType: "JSON",
            //             success: function(data) {
            //                 $('#formDatas #update_id').val(data.product.id);
            //                 $('#formDatas #name').val(data.product.name);
            //                 $('#formDatas #title').val(data.product.title);
            //                 $('#formDatas #description').val(data.product.description);

            //                 // if (data.product.image) {
            //                 //     let avatar = "{{ asset('') }}" +
            //                 //         data.product
            //                 //         .image;
            //                 //     $('#formDatas .dropify-preview').css('display',
            //                 //         'block');
            //                 //     $('#formDatas .dropify-render').html('<image src="' +
            //                 //         avatar +
            //                 //         '"/>');
            //                 //     $('#formDatas #old_image').val(data.product.image);
            //                 // }

            //                 $('#createP').text('Update Product');
            //                 $('#submitBtn').text('Update');
            //             },
            //         });
            //     }
            // });


            // //update product data
            // $(document).on('submit', '#formDatas', function(e) {
            //     e.preventDefault();

            //     var id = $('#formDatas #update_id').val();
            //     let formData = new FormData($('#formDatas')[0]);
            //     var url = "{{ route('products.update', ':id') }}";
            //     url = url.replace(':id', id);
            //     var name = $('#name').val();
            //     var title = $('#title').val();
            //     var description = $('#description').val();

            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });
            //     $.ajax({
            //         type: "put",
            //         url: url,
            //         data: {
            //             name: name,
            //             title: title,
            //             description: description,
            //         },
            //         contentType: false,
            //         processData: false,
            //         success: function(response) {
            //             $('#formDatas').find('.is-invalid').removeClass('is-invalid');
            //             $('#formDatas').find('.error').remove();

            //             if (response.status == false) {
            //                 $.each(response.errors, function(key, value) {
            //                     $('#formDatas #' + key).addClass('is-invalid');
            //                     $('#formDatas #' + key).parent().append(
            //                         '<div class="error d-block">' + value + '</div>'
            //                     );
            //                 });
            //             } else {
            //                 flashMessage(response.status, response.message);
            //                 if (response.status == 'success') {
            //                     $('#formDatas').find('input').val('');
            //                     $('.dropify-clear').click();
            //                     $('.ajax_dynamic').html(response.datas);
            //                 }
            //             }
            //         }
            //     });

            // });

            //delete product data

            $(document).on('click', '.delete_data', function() {
                let id = $(this).data('id');
                var url = "{{ route('products.destroy', ':id') }}";
                url = url.replace(':id', id);
                delete_data(id, url);
            });

            function delete_data(id, url) {
                Swal.fire({
                    title: 'Are you sure to delete data?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            url: url,
                            type: "delete",
                            dataType: "JSON",
                        }).done(function(response) {
                            if (response.status == "success") {
                                Swal.fire("Deleted", response.message, "success").then(function() {
                                    $('.ajax_dynamic').html(response.datas);
                                });
                            }
                        }).fail(function() {
                            swal.fire('Oops...', "Somthing went wrong with ajax!", "error");
                        });
                    }
                });
            }

            //toaster notification 
            function flashMessage(status, message) {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }

                switch (status) {
                    case 'success':
                        toastr.success(message, 'SUCCESS');
                        break;
                    case 'error':
                        toastr.error(message, 'ERROR');
                        break;
                    case 'info':
                        toastr.info(message, 'INFORMARTION');
                        break;
                    case 'warning':
                        toastr.warning(message, 'WARNING');
                        break;
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endpush
