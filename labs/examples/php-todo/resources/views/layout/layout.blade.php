<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>The Item App</title>
        <link rel="stylesheet" href="{{asset('css/pure-min.css')}}">
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body>

<div id="layout" class="content pure-g">
    <div id="nav" class="pure-u">
        <a href="#" id="menuLink" class="nav-menu-button"> &#x1F4A9; </a>

        <div class="nav-inner">
          @auth
          <form action="/item/create">
            <button class="pure-button button-primary">Compose</button>
          </form>

          <div class="pure-menu">
            <ul class="pure-menu-list">
              <li class="pure-menu-heading">Items</li>
              <li class="pure-menu-item"><a href="/item" class="pure-menu-link">All</a></li>
              <li class="pure-menu-item"><a href="/trash" class="pure-menu-link">Trash</a></li>
              <li class="pure-menu-heading">Profile</li>
              <li class="pure-menu-item"><a href="/logout" class="pure-menu-link">Logout</a></li>
            </ul>
            @endauth
            </div>
        </div>
    </div>
      @yield('content')
</div>
     <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
