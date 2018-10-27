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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="ml-5" method="POST" action='{{ route('penulis.store') }}'>
                        @csrf
                        @include('authors._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
