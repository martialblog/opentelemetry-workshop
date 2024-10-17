@extends('layout.layout')

@section('content')

<div id="list" class="pure-u-1">
  <h1 class="item-new">New Item</h1>

  @if ($errors->any())
  <div class="alert">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</lp>
    @endforeach
  </div>
  @endif

    <div class="item-item pure-g">

      <form class="pure-form" method="POST" action="/item">
        @csrf
          <label for="create-title">Title</label>
          <input type="text" id="create-title" class="pure-input-1" name="name" placeholder="Item Title" />

          <label for="create-content">Content</label>
          <textarea class="pure-input-1" id="create-content" name="content" placeholder="Item Content"></textarea>

          <fieldset class="pure-group">
            <button type="submit" class="pure-button pure-input-1-2 button-primary">Create</button>
          </fieldset>
      </form>
    </div>

</div>
@endsection
