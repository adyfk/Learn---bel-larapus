    <div class="form-group row">
            {!! Form::label('name', 'Nama', ['class'=>'col-sm-1 col-form-label']) !!}
            <?php $errors->has('name') ? $valid='is-invalid' : $valid='' ?>
            {!! Form::text('name', null, ['class'=>"form-control col-md-4 $valid"]) !!}
            {!! Form::submit('Simpan', ['class'=>'btn btn-primary ml-2']) !!}
    </div>
    {!! $errors->first('name', '<p class="help-block offset-md-1 text-danger">:message</p>') !!}
            
        