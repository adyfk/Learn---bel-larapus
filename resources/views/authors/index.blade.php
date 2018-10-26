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
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table id='table-author' class='table table-striped table-bordered'>
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Nama</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
        $('#table-author').DataTable({
            proccesing:true,
            serverSide:true,
            ajax:'{!! route('getdataauthor') !!}',
            columns : [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'}
            ]
        });
    })
</script>
@endsection
