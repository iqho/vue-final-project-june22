@extends('layouts.app')

@section('title', 'Update Product')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12 w-75">

            <div class="row justify-content-center g-0">
                <div class="col-12 text-end">
                    <a href="{{ route('priceTypes.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>

            <form method="post" action="{{ route('priceTypes.update', $priceType->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="card">

                    <div class="card-header">
                        <h3>Update Price Type</h3>
                    </div>

                    <div class="card-body" >

                        @if ($errors->any())
                            <div class="row">
                                <div class="col-12 alert alert-danger p-1 m-0">
                                    <ul class="g-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="row p-2">
                            <label for="name" class="col-md-2 col-form-label">Name <b class="text-danger">*</b></label>
                            <div class="col-md-10">
                                <input type="text" id="name" class="form-control" value="{{ $priceType['name'] }}"
                                    name="name" placeholder="Enter Price Type name" required autofocus>
                            </div>
                        </div>

                        <div class="card-footer float-end">
                            <button type="submit" class="btn btn-primary">Update Price Type</button>
                        </div>
                    </div>
                </div> <!-- /.card -->
            </form>
        </div>
    </div>
@endsection