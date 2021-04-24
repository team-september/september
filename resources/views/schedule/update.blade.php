@extends('layouts.base')

@section('content')
<section id="timepicker">
    <div class="container">
        <p class="text-center">予約を受け付ける時間を選んでください</p>
        <form action="{{ route('schedule.store') }}" method="post">
            @csrf
            @foreach ($settingDates as $availability)
            <label>日付：{{ $availability->available_date->format('Y.m.d') }}</label>
            <div class="form-group col-12 row">
                @for ($time = 9; $time <= 22; $time++)
                <div class="form-control col-4">
                    <input
                        class="ml-2" type="checkbox"
                        name="set_time[{{ $availability->available_date->format('Y-m-d') }}][]"
                        id="date_{{ $availability->available_date }}_{{ $time . ':00' }}"
                        @if( optional($availability->availableTimes)->pluck('time')->contains(date('H:i:s', strtotime($time . ':00'))) )
                        checked
                        @endif
                        value="{{ $time . ':00' }}"
                        >
                    <label for="date_{{ $availability->available_date }}_{{ $time . ':00' }}">{{ $time . ':00 ～' }}</label>
                </div>
                @endfor
            </div>
            @endforeach
            <div class="row justify-content-center">
                <button class="btn btn-primary">予約受付時間をセット</button>
            </div>
        </form>
    </div>
</section>
@endsection
