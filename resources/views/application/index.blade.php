@extends('layouts.base')

@section('content')
    {{--    @TODO:メンティーなら過去の応募内容、メンティーなら受け取った応募一覧を表示--}}
    <div class="text-center">
        @if($applications->isEmpty())
            応募がありません
        @else
            応募一覧を表示するページ
        @endif
    </div>
@endsection
