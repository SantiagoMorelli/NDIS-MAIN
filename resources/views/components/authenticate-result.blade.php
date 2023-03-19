<div>
    <div>
        <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
        <!-- succes - error messages -->


        @if (Session::has('success'))
            <div class="alert alert-success px-2 alert-timer" role="alert">
                <button data-dismiss="alert" class="close close-sm px-2" type="button">
                    <i class="fa fa-times"></i>
                </button>
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('error'))
            <div class="alert alert-danger alert-timer" role="alert">
                <button data-dismiss="alert" class="close close-sm" type="button">
                    <i class="fa fa-times"></i>
                </button>
                {{ Session::get('error') }}
            </div>
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-timer">
                    role="alert">
                    {{ $error }}
                </div>
            @endforeach
        @endif
        <!-- /succes - error messages -->
    </div>

</div>
@push('scripts')
    <script>
        // flash message timer
        // alert('here');
        setTimeout(function() {
            $('.alert-timer').fadeOut('fast');
        }, 3000);
    </script>
@endpush
