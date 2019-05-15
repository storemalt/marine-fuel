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
            <span class="badge badge-info">Trim commas</span><br>
            <p>
              <small>
                Remove commas from both sides of the array<br>
                https://www.php.net/manual/en/function.trim.php
              </small>
            </p>

            <span class="badge badge-info">Explode into an array</span> <br>
            <p>
              <small>
                using explode function, converted the string into a proper array<br>
                https://www.php.net/manual/en/function.explode.php
              </small>
            </p>

            <span class="badge badge-info">Array Count Values</span> <br>
            <p>
              <small>
                PHP function array_count_values counts the number of times a value appears in the array<br>
                https://www.php.net/manual/en/function.array-count-values.php
              </small>
            </p>

            <span class="badge badge-info">Arsort</span> <br>
            <p>
              <small>
                Reverse Sort (DESC) the associative array with flag as integer<br>
                https://www.php.net/manual/en/function.arsort.php
              </small>
            </p>

            <span class="badge badge-info">Array Slicing</span> <br>
            <p>
              <small>
                Get the array range from offset to given Number of Occurrence and preserve the keys<br>
                https://www.php.net/manual/en/function.array-slice.php
              </small>
            </p>

            <span class="badge badge-info">Array Keys</span> <br>
            <p>
              <small>
                Retrieve the key indexes as these contains the actual digits who frequently occurred<br>
                https://www.php.net/manual/en/function.array-keys.php
              </small>
            </p>

            <span class="badge badge-info">Array Implode to string</span> <br>
            <p>
              <small>
                Display array into a string of comma separated values<br>
                https://www.php.net/manual/en/function.implode.php
              </small>
            </p>

            <span class="badge badge-info">Display answer in flash message</span> <br>
            <p>
              <small>
                Display messages into flash session as a success message
              </small>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
