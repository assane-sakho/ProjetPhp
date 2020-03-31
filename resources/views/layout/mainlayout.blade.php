<!DOCTYPE html>
<html lang="fr">
  <head class="bg-light">
    @include('layout.partials.head')
  </head>
  <body>
      @include('layout.partials.nav')
      <div class="container-fluid">
        <div class="row">
          <main role="main" class="col-md-12 ml-sm-auto col-lg-12 px-4">
            <p/>
            <p/>
            @yield('content')
          </main>
        </div>
      </div>
      
      @include('layout.partials.footer')

      @include('layout.partials.footer-scripts')

      @yield('scripts')
  </body>
</html>