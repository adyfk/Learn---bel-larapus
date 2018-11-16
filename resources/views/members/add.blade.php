@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item" ><a href="{!! route('penulis.index') !!}">Penulis</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah Penulis</li>
                            </ol>
                        </nav>
            <div class="card">
                <div class="card-header">Penulis</div>
                <div class="card-body">
                    {!! Form::open(['url' => route('members.store'),'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal']) !!}
                        @include('members._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
