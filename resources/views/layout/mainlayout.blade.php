<!DOCTYPE html>
<html lang="fr">
  <head>
    @include('layout.partials.head')
  </head>
  <body class="bg-light">
      @include('layout.partials.nav')
      <div class="container-fluid">
        <div class="row">
          <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
            @yield('content')
          </main>
        </div>
      </div>
      
      @include('layout.partials.footer')

      @include('layout.partials.footer-scripts')

      @yield('scripts')
  </body>
</html>

