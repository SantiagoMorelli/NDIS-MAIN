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
          Reset Password
        </h1>
      </header><!-- form -->
      <form class="auth-form" id="resetPasswordForm"  novalidate="" action="{{ route('postResetPassword') }}" method="POST">
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
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
            <label class="d-flex justify-content-between" for="validationTooltipPassword"><span>New Password</span> <a href="#validationTooltipPassword" data-toggle="password"><i class="fa fa-eye fa-fw"></i> <span>Show</span></a></label>
             <input type="password" name="password" class="form-control" value="" id="validationTooltipPassword" placeholder="Password" required="" aria-describedby="inputGroupePassword">
             <div id="inputGroupePassword" class="invalid-feedback"> Password must be 8 character, one uppercase, one digit and one special character. </div>
          </div><!-- /form grid -->

      </div>
        <!-- .form-group -->
        <div class="form-group">
          <button class="btn btn-lg btn-primary btn-block" type="submit">Reset</button>
        </div><!-- /.form-group -->
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
        <script type="text/javascript">
          $(document).ready( function () {
            $('#resetPasswordForm').submit(function(e) {
              var count = 0;
              var password = $("#validationTooltipPassword").val();
              if ($.trim(password) == '') {
                $("#validationTooltipPassword").addClass('is-invalid');
                $("#validationTooltipPassword").removeClass('is-valid');
                count++;
              } else {
                if (password.length > 7 && password.match(/[a-z]+/) && password.match(/[A-Z]+/) && password.match(/[0-9]+/) && password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
                  $("#validationTooltipPassword").removeClass('is-invalid');
                  $("#validationTooltipPassword").addClass('is-valid');
                } else {
                  $("#validationTooltipPassword").addClass('is-invalid');
                  $("#validationTooltipPassword").removeClass('is-valid');
                  count++;
                }
              }

              if (count > 0) {
                return false;
              }
            });
          });
        </script>
        @stack('scripts')
    </body>
</html>
