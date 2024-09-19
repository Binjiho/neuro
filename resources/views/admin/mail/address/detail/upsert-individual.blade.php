@extends('admin.layouts.popup-layout')

@section('addStyle')
@endsection

@section('contents')
    <div class="sub-tit-wrap">
        <h3 class="sub-tit">명단 개별 {{ empty($addressDetail->sid) ? '등록' : '수정' }}</h3>
    </div>

    <form id="individual-frm" method="post" action="{{ route('mail.address.data') }}" data-ma_sid="{{ request()->ma_sid }}" data-sid="{{ $addressDetail->sid ?? 0 }}" data-case="individual-{{ empty($addressDetail->sid) ? 'create' : 'update' }}">
        <div class="write-wrap">
            <dl>
                <dt style="text-align: center;">이름</dt>
                <dd>
                    <input type="text" name="name" id="name" value="{{ $addressDetail->name ?? '' }}" class="form-item">
                </dd>
            </dl>

            <dl>
                <dt style="text-align: center;">이메일</dt>
                <dd>
                    <input type="text" name="email" id="email" value="{{ $addressDetail->email ?? '' }}" class="form-item">
                </dd>
            </dl>
        </div>

        <div class="btn-wrap text-center">
            <button type="submit" class="btn btn-type1 color-type20" id="submit">{{ empty($addressDetail->sid) ? '등록' : '수정' }}</button>
            <a href="javascript:window.close();" class="btn btn-type1 color-type3">취소</a>
        </div>
    </form>
@endsection

@section('addScript')
    <script>
        const form = '#individual-frm';
        const dataUrl = $(form).attr('action');

        $(document).on('submit', form, function () {
            const name = $('input[name=name]');
            const email = $('input[name=email]');

            if (isEmpty(name.val())) {
                alert('이름을 입력 해주세요.');
                name.focus();
                return false;
            }

            if (isEmpty(email.val())) {
                alert('이메일을 입력 해주세요.');
                email.focus();
                return false;
            }

            if (!emailCheck(email.val())) {
                alert('올바른 이메일 형식이 아닙니다.');
                email.focus();
                return false;
            }

            let ajaxData = formSerialize(form);
            ajaxData.ma_sid = $(form).data('ma_sid');

            callAjax(dataUrl, ajaxData);
        });
    </script>
@endsection
