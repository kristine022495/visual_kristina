<!DOCTYPE html>
<html lang="en">
  @include('layouts.header')
  @yield('header')
  <body>

      @include('layouts.navigation')
      @yield('content')

  </body>
  @include('layouts.scripts')
  @yield('scripts')
</html>
