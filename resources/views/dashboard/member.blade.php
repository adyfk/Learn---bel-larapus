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
               
                <div class="card-body">
                    Selamat datang di Larapus
                </div>
            </div>
        </div>
    </div>
</div>
@endsection