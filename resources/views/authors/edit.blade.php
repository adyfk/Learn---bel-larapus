@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item" ><a href="{!! route('penulis.index') !!}">Penulis</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Penulis</li>
                            </ol>
                        </nav>
            <div class="card">
                <div class="card-header">Penulis</div>
                <div class="card-body">
                    <div class="panel-body">
                        {!! Form::model($author, ['url' => route('penulis.update', $author->id),
                        'method'=>'put', 'class'=>'m-5']) !!}
                        @include('authors._form')
                        {!! Form::close() !!}                        
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
