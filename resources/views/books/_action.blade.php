{!! Form::model($model, ['url' => $form_url, 'method' => 'delete', 'class' => 'form-inline js-confirm', 'data-confirm' => $confirm_message] ) !!}
<a class="btn btn-primary btn-sm" href="{{ $edit_url }}">Ubah</a> |
{!! Form::submit('Hapus', ['class'=>'btn btn-sm btn-danger']) !!}
{!! Form::close()!!}

