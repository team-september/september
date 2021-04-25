@extends('layouts.base')

@section('content')
    <section id="application-check">
        <h2 class="text-center mt-3">申請一覧</h2>
        <div class="container">
            @if($reservations->isNotEmpty())
                @foreach($reservations as $reservation)
                    <div id="{{ $reservation->reservation_id }}" data-user-id="{{ $reservation->mentee_id }}"
                         class="js-reservation card mx-auto mt-3">
                        <div class="card-body">
                            <div class="d-md-flex justify-content-between mb-4 mb-md-0">
                                <div class="d-flex align-items-center">
                                    <div class="h5 font-weight-bold mr-2">{{ $reservation->name }}</div>
                                    @if($reservation->status === \App\Constants\ReservationStatus::APPROVED)
                                        <span class="badge badge-success">承認済み</span>
                                    @elseif($reservation->status === \App\Constants\ReservationStatus::APPLIED)
                                        <span class="badge badge-secondary">確認待ち</span>
                                    @else
                                        <span class="badge badge-danger">拒否</span>
                                    @endif

                                    {{-- 前日リマインド --}}
                                    @if(\Carbon\Carbon::parse($reservation->date)->eq(\Carbon\Carbon::today()->addDay(1)))
                                        <span class="ml-2 badge badge-info">明日</span>
                                    @endif
                                    {{-- 当日リマインド --}}
                                    @if(\Carbon\Carbon::parse($reservation->date)->eq(\Carbon\Carbon::today()))
                                        <span class="ml-2 badge badge-danger">今日</span>
                                    @endif
                                </div>
                                <div>申請日:{{ \Carbon\Carbon::parse($reservation->created_at)->format('Y/m/d') }}</div>
                            </div>
                            <p class="font-weight-bold">
                                希望日：{{ \Carbon\Carbon::parse($reservation->date)->format('Y/m/d') }} {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</p>
                            @if($reservation->mentor_comment)
                                <p>{{ $reservation->mentor_comment }}</p>
                            @endif
                        </div>

                    </div>
                @endforeach
            @else
                <div class="d-flex justify-content-center">まだ申請がありません。</div>
            @endif
        </div>
    </section>
@endsection
