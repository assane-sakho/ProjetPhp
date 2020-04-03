<!DOCTYPE html>
<html lang="fr">
  <head class="bg-light">
    @include('layout.partials._head')
  </head>
  <body>
      @include('layout.partials._nav')
      
      @yield('content')
      
      @include('layout.partials._footer')

      @include('layout.partials._footer-scripts')

      @yield('scripts')
  </body>
</html>