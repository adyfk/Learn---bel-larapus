@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{!! route('home') !!}">Dashboard</a></li>
                            </ol>
                        </nav>
            <div class="card"> 
                <div class="card-body position-relative">
                    <a class="btn btn-primary position-absolute" style="bottom:10px;right:10px;" href="{{ url('/settings/profile/edit') }}">Ubah</a>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td class="text-muted">Nama</td>
                                <td>{{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email</td>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection