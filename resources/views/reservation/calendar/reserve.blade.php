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
                @if($day->is_available) {{-- メンティー用表示 --}}
                <div onclick="getModalContents({{$mentor_id}}, '{{$day->date}}')" role="button" class="text-success" data-toggle="modal" data-target="#reservationModal">{!! Icons::PLUS !!}</div>
                @else {{-- 過去の日付など、設定ができないor無効な日 --}}
                <p class="text-danger">{!! Icons::SLASH !!}</p>
                @endif
            </div>
        </td>
        @endif
    @endforeach
    </tr>
@endforeach

@section('modal-window')
@include('reservation.modal')
@endsection