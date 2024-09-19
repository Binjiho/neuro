@extends('admin.layouts.admin-layout')

@section('addStyle')
@endsection

@section('contents')
    <section id="container" class="inner-layer">
        @include('admin.layouts.include.sub-tit')

        <div class="sub-contents">
            <form id="searchF" name="searchF" action="{{ route('member') }}" class="sch-form-wrap">
                <fieldset>
                    <legend class="hide">검색</legend>
                    <div class="table-wrap">
                        <table class="cst-table">
                            <colgroup>
                                <col style="width: 30%;">
                                <col>
                            </colgroup>

                            <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td class="text-left">
                                    <input type="text" name="uid" value="{{ request()->uid ?? '' }}" class="form-item">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn-wrap text-center">
                        <button type="submit" class="btn btn-type1 color-type17">검색</button>
                        <a href="{{ route('member') }}" class="btn btn-type1 color-type18">검색 초기화</a>
                        <a href="{{ route('member.excel', request()->except(['page'])) }}" class="btn btn-type1 color-type19">Get Excel File</a>
                    </div>
                </fieldset>
            </form>

            <div class="table-wrap" style="margin-top: 10px;">
                <table class="cst-table list-table">
                    <caption class="hide">목록</caption>

                    <colgroup>
                        <col style="width: 5%;">
                        <col style="width: 8%;">
                        <col style="width: 8%;">
                        <col>
                        <col style="width: 6%;">
                    </colgroup>

                    <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">ID</th>
                        <th scope="col">이름</th>
                        <th scope="col">가입일</th>
                        <th scope="col">관리</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($list as $row)
                        <tr data-sid="{{ $row->sid }}">
                            <td>{{ $row->seq }}</td>
                            <td>{{ $row->uid }}</td>
                            <td>{{ $row->name_kr }}</td>
                            <td>{{ $row->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('member.upsert', ['sid' => $row->sid]) }}" class="btn-admin call-popup" data-popup_name="member-upsert" data-width="850" data-height="900">
                                    <img src="/assets/image/admin/ic_modify.png" alt="수정">
                                </a>

                                <a href="javascript:void(0);" class="btn-admin btn-del">
                                    <img src="/assets/image/admin/ic_del.png" alt="삭제">
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">등록된 회원이 없습니다.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $list->links('pagination::custom') }}
        </div>
    </section>
@endsection

@section('addScript')
    <script>
        const dataUrl = '{{ route('member.data') }}';

        const getPK = (_this) => {
            return $(_this).closest('tr').data('sid');
        }
    </script>
@endsection
