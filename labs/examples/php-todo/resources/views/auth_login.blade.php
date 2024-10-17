@extends('layout.layout')

@section('content')

<div id="main" class="pure-u-1">
  <div class="item-content">
    <div class="item-content-header pure-g">
      <div class="pure-u-1-2">
        <h1 class="item-content-title">The Item App</h1>
      </div>
    </div>

      @if ($errors->any())
      <div class="alert">
          @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
      </div>
      @endif

    <div>
      <form class="pure-form pure-form-aligned" method="POST" action="{{ route('authenticate') }}">
      @csrf
        <fieldset>
          <div class="pure-control-group">
            <label for="aligned-email">Email Address</label>
            <input type="email" id="aligned-email" name="email" placeholder="Email Address" />
          </div>
          <div class="pure-control-group">
            <label for="aligned-password">Password</label>
            <input type="password" id="aligned-password" name="password" placeholder="Password" />
          </div>
          <div class="pure-controls">
            <label for="aligned-remember" class="pure-checkbox">
              <input type="checkbox" id="aligned-remember" /> Remember me
            </label>
            <button type="submit" class="pure-button pure-button-primary">Login</button>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>
@endsection
