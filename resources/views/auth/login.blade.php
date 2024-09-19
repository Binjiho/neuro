@extends('layouts.web-layout')

@section('addStyle')
@endsection

@section('contents')
    <form id="login-frm" method="post">
        <input type="text" id="uid" name="uid" placeholder="ID" noneSpace>
        <input type="password" id="password" name="password" placeholder="password" noneSpace>
        <button type="submit">Login</button>
    </form>
@endsection

@section('addScript')
    <script>
        const form = '#login-frm';
        const dataUrl = '{{ route('login') }}';

        defaultVaildation();

        $(form).validate({
            rules: {
                uid: {
                    isEmpty: true,
                },
                password: {
                    isEmpty: true,
                },
            },
            messages: {
                uid: {
                    isEmpty: "아이디를 입력 해주세요.",
                },
                password: {
                    isEmpty: "비밀번호를 입력 해주세요.",
                },
            },
            submitHandler: function () {
                callAjax(dataUrl, formSerialize(form));
            }
        });
    </script>
@endsection
