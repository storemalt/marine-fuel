@if ($message = Session::get('success'))
  <div class="row">
    <div class="col-12">
      <div class="alert alert-success" role="alert">
        {{ $message }}
      </div>
    </div>
  </div>
@endif

@if ($message = Session::get('error'))
  <div class="row">
    <div class="col-12">
      <div class="alert alert-danger" role="alert">
        {{ $message }}
      </div>
    </div>
  </div>
@endif

@if ($message = Session::get('warning'))
  <div class="row">
    <div class="col-12">
      <div class="alert alert-warning" role="alert">
        {{ $message }}
      </div>
    </div>
  </div>
@endif

@if ($message = Session::get('info'))
  <div class="row">
    <div class="col-12">
      <div class="alert alert-info" role="alert">
        {{ $message }}
      </div>
    </div>
  </div>
@endif

@if ($errors->any())
  <div class="row">
    <div class="col-12">
      @foreach ($errors->all() as $error)
        <div class="row">
          <div class="col-12">
            <div class="alert alert-danger" role="alert">
              {{ $error }}
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endif
