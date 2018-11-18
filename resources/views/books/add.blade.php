@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item" ><a href="{!! route('buku.index') !!}">Buku</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah Buku</li>
                            </ol>
                        </nav>
            <div class="card">
                <div class="card-header">Buku</div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#form" aria-controls="form" role="tab" data-toggle="tab">
                                <i class="fa fa-pencil-square-o"></i> Isi Form
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#upload" aria-controls="upload" role="tab" data-toggle="tab">
                                <i class="fa fa-cloud-upload"></i> Upload Excel
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="form">
                        {!! Form::open(['url' => route('buku.store'),'method' => 'post', 'files'=>'true', 'class'=>'ml-5']) !!}
                        @csrf
                        @include('books._form')
                        {!! Form::close() !!}
                    </div>
                    <div role="tabpanel" class="tab-pane" id="upload">
                        {!! Form::open(['url' => route('import.books'),'method' => 'post', 'files'=>'true', 'class'=>'ml-5']) !!}
                        @csrf
                        @include('books._import')
                        {!! Form::close() !!}
                        </div>
                    </div>                        
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
