{{-- Scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('plugins/moment/js/moment.min.js') }}"></script>
<script src="{{ asset('plugins/crypto-js/crypto-js.min.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/js/flatpickr.min.js') }}"></script>
<script src="{{ asset('plugins/flatpickr/js/flatpickr-ko.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('script/app/app.common.js') }}?v={{ config('site.app.asset_version') }}"></script>

@if(Session::has('msg') && !empty(Session::get('msg')))
    <script>
        alert('{!! Session::pull("msg") !!}');
    </script>
@endif

@if(auth('web')->check())
    <script>
        const logout = () => {
            if (confirm('로그아웃 하시겠습니까?')) {
                callAjax('{{ route('logout') }}', {});
            }
        }
    </script>
@endif