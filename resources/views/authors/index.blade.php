@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Penulis</li>
                            </ol>
                        </nav>
            <div class="card">
                <div class="card-header">Penulis</div>
                <div class="card-body">
                    <p> <a class="btn btn-primary" href="{{ route('penulis.create') }}">Tambah</a> </p>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {!! $html->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    {!! $html->scripts() !!}
@endpush
