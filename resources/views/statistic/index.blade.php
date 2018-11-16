@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
                        <nav aria-label="breadcrumb ">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Data Peminjam</li>
                            </ol>
                        </nav>
            <div class="card">
                <div class="card-header">Data Peminjam</div>
                <div class="card-body">
                        {!! $html->table() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    {!! $html->scripts() !!}
    <script>
    $(function(){
        $('\
                        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
                                    <label>Status \
                                        <select size="1" name="filter_status" aria-controls="filter_status" class="form-control input-sm form-control-sm " style="width: 140px;">\
                                        <option value="all" selected="selected">Semua</option>\
                                        <option value="returned">Sudah Dikembalikan</option>\
                                        <option value="not-returned">Belum Dikembalikan</option>\
                                    </select>\
                                    </label>\
                                </div>\
        ').insertAfter('.dataTables_filter');
        $('.dataTables_filter').css("float", "right");  
        $("#dataTableBuilder").on('preXhr.dt', function(e, settings, data) {
            data.status = $('select[name="filter_status"]').val();
        });
        $('select[name="filter_status"]').change(function() {
            window.LaravelDataTables["dataTableBuilder"].ajax.reload();
        });
    });
</script>

@endpush