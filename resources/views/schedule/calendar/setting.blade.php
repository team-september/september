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
            <div style="color:#333">
            <div class="form-group">
                <select name="availability_setting[{{ $day->date }}][is_available]]" id="is_available_flg_{{ $day->date }}" class="form-control">
                @if($day->is_available)
                    <option value="1" selected>予約可</option>
                    <option value="0">予約不可</option>
                @else
                    <option value="1">予約可</option>
                    <option value="0" selected>予約不可</option>
                @endif
                </select>
            </div>
        </td>
        @endif
    @endforeach
    </tr>
@endforeach