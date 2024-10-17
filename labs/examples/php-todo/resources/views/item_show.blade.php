@extends('layout.layout')

@section('content')
<div id="list" class="pure-u-1">
  <div class="item-item pure-g">
      <div class="pure-u-3-4">
          <h6 class="item-name">{{ $item->user->name }}</h5>
          <h3 class="item-subject">{{ $item->name }}</h4>
          <div class="item-control">
            <form class="pure-form" action="{{ route('item.edit', $item->id) }}">
              <button class="pure-button button-primary item-edit-control">Edit</button>
            </form>
            @if (isset($item->deleted_at))
            <form class="pure-form" action="{{ route('item.restore', $item->id) }}" method="post">
              @csrf
              @method('PUT')
              <button type="submit" class="pure-button button-secondary item-edit-control">Restore</button>
            </form>
            @else
            <form class="pure-form" action="{{ route('item.delete', $item->id) }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" class="pure-button button-secondary item-edit-control">Remove</button>
            </form>
            @endif
          </div>
          <div class="item-desc">
            <p>{{ $item->content }}</p>
          </div>
      </div>
  </div>
@endsection
