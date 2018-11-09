@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item" ><a href="{!! route('buku.index') !!}">Buku</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
                            </ol>
                        </nav>
            <div class="card">
                <div class="card-header">Buku</div>
                <div class="card-body">
                    <div class="panel-body">
                        {!! Form::model($book, ['url' => route('buku.update', $book->id),'method'=>'put', 'files'=>'true','class'=>'m-5']) !!}
                        @include('books._form')
                        {!! Form::close() !!}                        
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select/bootstrap-select.min.css') }}">
    <script src="{{ asset('js/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script>
        $.fn.selectpicker.Constructor.BootstrapVersion = '4.1.1';
        $(document).ready(function(){
           $('.selectpicker').selectpicker()
        })
    </script>
@endpush