       <div class="form-group row {{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', 'Judul', ['class'=>'col-sm-1 col-form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control col-md-4']) !!}
        </div>
        {!! $errors->first('title', '<p class="help-block offset-md-1 text-danger">:message</p>') !!}
        <div class="form-group row {{ $errors->has('author_id') ? ' has-error' : '' }}">
                {!! Form::label('author_id', 'Penulis', ['class'=>'col-sm-1 col-form-label']) !!}
                {!! Form::select('author_id',App\Author::pluck('name','id')->all(), null,['class'=>'selectpicker','data-width '=>'auto', 'data-live-search'=>'true','multiple title'=>'Pilih Penulis...']) !!}
        </div>
        {!! $errors->first('author_id', '<p class="help-block offset-md-1 text-danger">:message</p>') !!}
        <div class="form-group row {{ $errors->has('amount') ? ' has-error' : '' }}">
                {!! Form::label('amount', 'Jumlah', ['class'=>'col-sm-1 col-form-label']) !!}
                {!! Form::text('amount', null, ['class'=>'form-control col-md-4']) !!}
        </div>
        @if(isset($book))
                <p class="help-block">{{ $book->borrowed }} buku sedang dipinjam</p>
        @endif
        {!! $errors->first('amount', '<p class="help-block offset-md-1 text-danger">:message</p>') !!}
        <div class="form-group row {{ $errors->has('cover') ? ' has-error' : '' }}">
                {!! Form::label('', 'Cover', ['class'=>'col-sm-1 col-form-label']) !!}
                {!! Form::file('cover') !!}
                @if (isset($book) && $book->cover)
                        <p>
                        {!! Html::image(asset('img/'.$book->cover), null, ['class'=>'img-rounded img-responsive']) !!}
                        </p>
                @endif
        </div>
        {!! $errors->first('cover', '<p class="help-block offset-md-1 text-danger">:message</p>') !!}
        <div class="form-group">
                {!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!}
        </div>    
