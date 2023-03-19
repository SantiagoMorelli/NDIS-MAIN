<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><!-- End Required meta tags -->
    <title>@yield('title','Forgot Password')</title>
    <meta name="theme-color" content="#3063A0">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600" rel="stylesheet"><!-- End GOOGLE FONT -->
    <!-- BEGIN PLUGINS STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css') }}"><!-- END PLUGINS STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.min.css') }}" data-skin="default">
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-dark.min.css') }}" data-skin="dark">
    <link rel="stylesheet" href="{{ asset('assets/stylesheets/custom.css') }}">

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
      <!-- form -->
      <form class="auth-form auth-form-reflow needs-validation" id="forgotPasswordForm" novalidate="" action="{{ route('forgotPasswordPost') }}" method="POST">
        <div class="text-center mb-4">
          <div class="mb-4">
          </div>
          <h1 class="h3"> Reset Your Password </h1>
        </div>
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
        <!-- .form-group -->
        <div class="form-group mb-4">
            <label for="validationTooltipEmail">Email</label>
              <input type="text" class="form-control" id="validationTooltipEmail" placeholder="Email" name="email" aria-describedby="inputGroupeEmail" required="">
              <div id="inputGroupeEmail" class="invalid-feedback"> Please enter a email. </div>
          <p class="text-muted">
            <small>We'll send password reset link to your email.</small>
          </p>
        </div><!-- /.form-group -->
        <!-- actions -->
        <div class="d-block d-md-inline-block mb-2">
          <button class="btn btn-lg btn-block btn-primary" type="submit">Reset Password</button>
        </div>
        <div class="d-block d-md-inline-block">
          <a href="{{ route('login') }}" class="btn btn-block btn-light">Return to signin</a>
        </div>
      </form><!-- /.auth-form -->
    </main><!-- /.auth -->

        <!-- BEGIN BASE JS -->
        <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/popper.js/umd/popper.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script> <!-- END BASE JS -->
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
