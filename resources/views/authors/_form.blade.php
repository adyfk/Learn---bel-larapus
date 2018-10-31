    <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Nama', ['class'=>'col-sm-1 col-form-label']) !!}
            {!! Form::text('name', null, ['class'=>'form-control col-md-4']) !!}
            {!! Form::submit('Simpan', ['class'=>'btn btn-primary ml-2']) !!}
    </div>
    {!! $errors->first('name', '<p class="help-block offset-md-1 text-danger">:message</p>') !!}
            
        