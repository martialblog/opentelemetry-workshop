@extends('layout.layout')

@section('content')

<div id="list" class="pure-u-1">
  <h1>{{ $item->name }}</h1>

  @if ($errors->any())
  <div class="alert">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</lp>
    @endforeach
  </div>
  @endif

    <div class="item-item pure-g">

      <form class="pure-form" method="post" action="/item/{{ $item->id }}">
        @csrf
        @method('PUT')
          <label for="create-title">Title</label>
          <input type="text" id="create-title" class="pure-input-1" name="name" value="{{ $item->name }}"/>

          <label for="create-content">Content</label>
          <textarea class="pure-input-1" id="create-content" name="content">{{ $item->content }}</textarea>

          <fieldset class="pure-group">
            <button type="submit" class="pure-button pure-input button-primary">Update</button>
            <a class="pure-button" href="/item/{{ $item->id }}">Cancel</a>
          </fieldset>
      </form>
    </div>

</div>
@endsection
