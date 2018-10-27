    <div class="form-group row">
        <label for="Nama" class="col-sm-1 col-form-label">Nama</label>
        <input type="text" class="form-control col-md-4" id="name" name='name' placeholder="Nama Penulis">
        <button type="submit" class="btn btn-primary ml-2">Submit</button>
    </div>
        {!! $errors->first('name', '<p class="help-block offset-md-1 text-danger">:message</p>') !!}
        
