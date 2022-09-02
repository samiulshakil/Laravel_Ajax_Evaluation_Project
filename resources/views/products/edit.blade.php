@extends('layouts.master')
@section('contents')
    <h4 class="text-center">Update Products</h4>
    <div class="container">
        <div class="row" style="padding-top: 50px;">
            <div class="col-md-6 mx-auto">
                <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-2">
                        <label for="name" class="col-form-label text-md-end">{{ __('Product Name') }}</label>
                        <input type="text" class="form-control" value="{{ $product->name }}" name="name"
                            id="name" style="border-radius: 5px">
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
                        <input type="text" class="form-control" value="{{ $product->title }}" name="title"
                            id="title" style="border-radius: 5px">
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
                        <input type="text" class="form-control" value="{{ $product->description }}" name="description"
                            id="description" style="border-radius: 5px">
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
                        <input type="file" id="image" data-show-errors="true"
                            class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                    </div>
                    @error('image')
                        <p>
                            <span class="text-danger" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        </p>
                    @enderror

                    <button type="submit" class="btn btn-primary mb-2 bg-primary">
                        <span>Update</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
