<!DOCTYPE html>
<html lang="fr">
  <head class="bg-light">
    @include('layout.partials.head')
  </head>
  <body>
      @include('layout.partials.nav')
      
      @yield('content')
      
      @include('layout.partials.footer')

      @include('layout.partials.footer-scripts')

      @yield('scripts')
  </body>
</html>