@extends('layouts.web-layout')

@section('addStyle')
    <link rel="stylesheet" href="{{ asset('assets/board/css/board.css') }}">
@endsection

@section('contents')
    <article class="sub-contents">
        <div class="page-tit-wrap inner-layer">
            <h3 class="page-tit">{{ $boardConfig['name'] }}</h3>
        </div>

        <div class="sub-conbox inner-layer">
            <div id="board" class="board-wrap">
                <div class="sch-form-wrap">
                    <form id="bbsSearch" action="{{ route('board', ['code' => $code]) }}" method="get">
                        <fieldset>
                            <legend class="hide">검색</legend>

                            <div class="sch-wrap">
                                <span class="cnt">
                                    {{ empty(request()->search) ? 'ALL' : $boardConfig['search'][request()->search] }}
                                    <strong class="text-blue">{{ $list->total() }}</strong>
                                </span>

                                <div class="form-group">
                                    <select name="search" id="search" class="form-item sch-cate">
                                        <option value="">ALL</option>

                                        @foreach($boardConfig['search'] as $key => $val)
                                            <option value="{{ $key }}" {{ ((request()->search ?? '') == $key) ? 'selected'  : '' }}>{{ $val }}</option>
                                        @endforeach
                                    </select>

                                    <input type="text" name="keyword" id="keyword" class="form-item sch-key" value="{{ request()->keyword ?? '' }}">

                                    <button type="submit" class="btn btn-sch"><span class="hide">검색</span></button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>

                <ul class="board-list">
                    <li class="list-head">
                        <div class="bbs-no bbs-col-xs n-bar">No</div>
                        <div class="bbs-tit n-bar">{{ $boardConfig['subject'] }}</div>
                        <div class="bbs-file bbs-col-xs n-bar">File</div>
                        <div class="bbs-date bbs-col-m">Date</div>
                        <div class="bbs-cate bbs-col-s">Hits</div>

                        @if(isAdmin())
                            <div class="bbs-admin bbs-col-s">M/D</div>
                        @endif
                    </li>

                    @forelse($list as $row)
                        <li data-sid="{{ $row->sid }}" data-secret="{{ $row->secret }}">
                            <div class="bbs-no bbs-col-xs n-bar">{{ $row->seq }}</div>

                            <div class="bbs-tit n-bar">
                                <a href="{{ route('board.view', ['code' => $code, 'sid' => $row->sid]) }}" class="ellipsis">
                                    {{ $row->subject }}
                                </a>

                                {{ $row->isNew() }}
                            </div>

                            <div class="bbs-file bbs-col-xs n-bar">
                                @if($row->files_count > 0)
                                    <a href="{{ $row->plDownloadUrl() }}">
                                        <img src="/html/bbs/notice/assets/image/ic_attach_file.png" alt="">
                                    </a>
                                @endif
                            </div>

                            <div class="bbs-date bbs-col-m">{{ $row->created_at->format('Y.m.d') }}</div>

                            <div class="bbs-cate bbs-col-s">{{ number_format($row->ref) }}</div>

                            @if(isAdmin())
                                <div class="bbs-admin bbs-col-s">
                                    <div class="btn-admin">
                                        <a href="{{ route('board.upsert', ['code' => $code, 'sid' => $row->sid]) }}" class="btn btn-modify">
                                            <span class="hide">수정</span>
                                        </a>

                                        <a href="javascript:void(0);" class="btn btn-delete">
                                            <span class="hide">삭제</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </li>
                    @empty
                        <li class="no-data text-center">
                            No Contents.
                        </li>
                    @endforelse
                </ul>

                {{ $list->links('pagination::custom') }}
            </div>
            <!-- e:board -->
        </div>
    </article>
@endsection

@section('addScript')
    @include("board.default-script")

    <script>
        $(document).on('click', '.btn-delete', function() {
            const ajaxData = {
                case: 'board-delete',
                sid: getPK(this),
            }

            if (confirm('정말로 삭제 하시겠습니까?')) {
                callAjax(dataUrl, ajaxData);
            }
        });
    </script>
@endsection
