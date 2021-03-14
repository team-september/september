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
            <a class="btn btn-outline-secondary p-1" href="?ym={{ $prevMonth }}">&lt;&lt; 前の月</a>
            <span class="month h4">{{ $currentMonth }}</span>
            <a class="btn btn-outline-secondary p-1" href="?ym={{ $nextMonth }}">&gt;&gt; 次の月</a>
        </div>
        <div class="calendar mt-2">
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
                    @foreach ($calendarData as $week)
                        <tr>
                        @foreach ($week as $day)
                            @if(is_null($day)) {{-- 当月ではない日 --}}
                            
                            <td class="past"></td>
                            
                            @elseif($day->is_past) {{-- 過去の日付 --}}
                            <td class="disabled text-muted {{ $day->day }}">
                                {{ $day->date_j }}
                                <p>{!! Icons::SLASH !!}</p>
                            </td>
                            
                            @elseif($day->is_today) {{-- 当日 --}}
                            <td class="{{ $day->day }} today">
                                {{ $day->date_j }}
                                <p class="text-muted">{!! Icons::SLASH !!}</p>
                            </td>

                            @else {{-- 当日以降 --}}
                            <td class="{{ $day->day }}">
                                <span class="date">{{ $day->date_j }}</span>
                                <div class="icon">
                                    @if ($user->is_mentor) {{-- メンター用表示 --}}
                                    <a href="{{ route('reservation.setting', $day->date) }}" class="text-primary">{!! Icons::SETTINGS !!}</a>
                                    @elseif($day->is_available) {{-- メンティー用表示 --}}
                                    <a href="{{ route('reservation.reserve', $day->date) }}" class="text-success">{!! Icons::PLUS !!}</a>
                                    @else {{-- 過去の日付など、設定ができないor無効な日 --}}
                                    <p class="text-danger">{!! Icons::SLASH !!}</p>
                                    @endif
                                </div>
                            </td>
                            @endif
                        @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection