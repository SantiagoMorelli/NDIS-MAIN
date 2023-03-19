<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- End Required meta tags -->
    <title>@yield('title','Login')</title>
    <meta name="theme-color" content="#3063A0">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End GOOGLE FONT -->
    <!-- BEGIN PLUGINS STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/open-iconic/font/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css') }}"><!-- END PLUGINS STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.min.css') }}" data-skin="default">
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-dark.min.css') }}" data-skin="dark">
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/custom.css') }}">
    @stack('styles')

    <script>
      var skin = localStorage.getItem('skin') || 'default';
      var disabledSkinStylesheet = document.querySelector('link[data-skin]:not([data-skin="' + skin + '"])');
      // Disable unused skin immediately
      disabledSkinStylesheet.setAttribute('rel', '');
      disabledSkinStylesheet.setAttribute('disabled', true);
      // add loading class to html immediately
      document.querySelector('html').classList.add('loading');
    </script><!-- END THEME STYLES -->
  </head>
    <body>
        <!-- .auth -->
    <main class="auth">
      <header id="auth-header" class="auth-header">
        <h1>
          BettercareNDIS
        </h1>
      </header><!-- form -->
      <form class="needs-validation auth-form" id="createUserForm"  novalidate="" action="{{ url('admin/login') }}" method="POST">
        @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
              <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
              </button>
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
              <button data-dismiss="alert" class="close close-sm" type="button">
                                <i class="fa fa-times"></i>
              </button>
                {{ session()->get('error') }}
            </div>
        @endif
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                     {{ $error }}
                </div>
            @endforeach
        @endif
        <div class="form-row">
          <!-- form grid -->
          <div class="col-md-12 mb-3">
            <label for="validationTooltipEmail">Email </label>
            <input type="text" class="form-control" id="validationTooltipEmail" placeholder="Email" name="email" aria-describedby="inputGroupeEmail" required="">
            <div id="inputGroupeEmail" class="invalid-feedback"> Please enter a email. </div>
          </div><!-- /form grid -->

          <!-- form grid -->
          <div class="col-md-12 mb-3">
            <label class="d-flex justify-content-between" for="validationTooltipPassword"><span>Password</span> <a href="#validationTooltipPassword" data-toggle="password"><i class="fa fa-eye fa-fw"></i> <span>Show</span></a></label>
             <input type="password" name="password" class="form-control" value="" id="validationTooltipPassword" placeholder="Password" required="" aria-describedby="inputGroupePassword">
             <div id="inputGroupePassword" class="invalid-feedback"> Please enter a password. </div>
          </div><!-- /form grid -->

      </div>
        <!-- .form-group -->
        <div class="form-group">
          <button class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
        </div><!-- /.form-group -->
        <!-- .form-group -->
        <!-- <div class="form-group text-center">
          <div class="custom-control custom-control-inline custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="remember-me"> <label class="custom-control-label" for="remember-me">Keep me sign in</label>
          </div>
        </div> --><!-- /.form-group -->
        <!-- recovery links -->
        <div class="text-center pt-3">
          <span class="mx-2"></span> <a href="{{ route('forgotPassword') }}" class="link">Forgot Password?</a>
        </div> <!-- /recovery links -->
      </form><!-- /.auth-form -->
    </main><!-- /.auth -->
        <!-- BEGIN BASE JS -->
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/popper.js/umd/popper.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script> <!-- END BASE JS -->
        <!-- BEGIN PLUGINS JS -->
        <script src="{{ asset('assets/vendor/pace-progress/pace.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/stacked-menu/js/stacked-menu.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script> <!-- END PLUGINS JS -->
        <!-- BEGIN THEME JS -->
        <script src="{{ asset('assets/javascript/theme.min.js') }}"></script> <!-- END THEME JS -->
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="{{ asset('https://www.googletagmanager.com/gtag/js?id=UA-116692175-1') }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];

          function gtag()
          {
            dataLayer.push(arguments);
          }
          gtag('js', new Date());
          gtag('config', 'UA-116692175-1');
        </script>
        @stack('scripts')
    </body>
</html>
