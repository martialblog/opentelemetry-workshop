@extends('layout.layout')

@section('content')

<div id="list" class="pure-u-1">

  @if (!request()->routeIs('trash'))
  @include('search')
  @endif

  @if (request()->routeIs('trash'))
  @include('trash_control')
  @endif

  @foreach ($items as $i)
  <div class="item-item pure-g">
    <div class="pure-u-3-4">
      <h6 class="item-name">{{ $i->user->name }}</h5>
      <h3 class="item-subject"><a class="item-item-link" href="/item/{{ $i->id }}">{{ $i->name }}</a></h4>
      <p class="item-desc">{{ Str::limit($i->content, 64) }}</p>
    </div>
  </div>
  @endforeach
</div>
@endsection
