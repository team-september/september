@extends('layouts.base')

@section('content')
<style>
    .past {
        background:silver;
    }
    .disabled {
        background:lightgray;
    }
    .today {
        background:gold;
    }
    .sat {
        color:blue;
    }
    .sun {
        color:red;
    }
</style>
<section id="calendar" class="flex-center position-ref full-height">
    <div class="container">
        <div class="text-center row justify-content-between m-auto">
            <a class="btn btn-outline-secondary p-2" href="?ym={{ $prevMonth->format('Y-m') }}">&lt;&lt; 前の月</a>
            <span class="month h4">{{ $currentMonth->format('Y年m月') }}</span>
            <a class="btn btn-outline-secondary p-2" href="?ym={{ $nextMonth->format('Y-m') }}">次の月 &gt;&gt;</a>
        </div>
        <div class="calendar mt-2">
            @if ($user->is_mentor)
            <form action="{{route('reservation.setting')}}" method="post">
                @csrf
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>月</th>
                        <th>火</th>
                        <th>水</th>
                        <th>木</th>
                        <th>金</th>
                        <th>土</th>
                        <th>日</th>
                    </tr>
                </thead>
                <tbody>
                @if ($user->is_mentor)
                    @include('reservation.calendar.setting')
                @else
                    @include('reservation.calendar.reserve')
                @endif
                </tbody>
            </table>
            @if ($user->is_mentor)
                <div class="row justify-content-center">
                    <button class="btn btn-primary">予約可能状況を更新</button>
                </div>
            </form>
            @endif
        </div>
        @yield('modal-window')
    </div>
</section>
@endsection