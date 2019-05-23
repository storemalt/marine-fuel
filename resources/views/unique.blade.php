@extends('layouts.app')

@section('css')
@endsection

@section('content')
  <div class="container">
    <div class="row justify-content-center mb-sm-4">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Unique String</h5>
          </div>
          <div class="card-body">
            <form method="post" action="{{$action}}">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="array_values">Input a set of random repeating characters
                  <code>'aaaabbbbbcccccdde'</code>
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="word"
                  name="word"
                  value="{{ old('word') }}"
                  aria-describedby="word"
                  placeholder="aaaabbbbbcccccdde">
                <small id="emailHelp" class="form-text text-muted">
                  Do not leave blank values with commas, no comma
                  before and after the last and first number
                </small>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mb-sm-4">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">Explanation</h5>
          </div>
          <div class="card-body">
            <span class="badge badge-info">Count Characters</span><br>
            <p>
              <small>
                Returns information about a string, set to mode 3 to return unique<br>
                https://www.php.net/manual/en/function.count-chars.php
              </small>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
