@extends('layouts.base')

@push('scripts')
    <script type="text/javascript">
        $(function () {
            $('.js-reservation').on('click', function () {
                const selected_reservation = $(this);

                // 既に選択済みの場合、ボーダー解除して値を空にする
                if (selected_reservation.hasClass('border-3')) {
                    selected_reservation.removeClass('border-3 border-primary');
                    selected_reservation.find('.js-reservation-id').val('');
                    selected_reservation.find('.js-user-id').val('');
                } else { // 未選択の場合、ボーダーつけて値を入れる
                    selected_reservation.addClass('border-3 border-primary');
                    selected_reservation.find('.js-reservation-id').val(selected_reservation.attr('id'));
                    selected_reservation.find('.js-user-id').val(selected_reservation.attr('data-user-id'));
                }
            });
        });
    </script>
@endpush


@section('content')
    <section id="application-check">
        <h2 class="text-center mt-3">申請一覧</h2>
        <div class="container">
            @if($reservations->isNotEmpty())
                @foreach($reservations as $reservation)
                    <div id="{{ $reservation->reservation_id }}" data-user-id="{{ $reservation->mentee_id }}"
                         class="js-reservation card mx-auto mt-3" style="cursor: pointer;">
                        <div class="card-body">
                            <div class="d-md-flex justify-content-between mb-4 mb-md-0">
                                <h5 class="card-title">{{ $reservation->name }}</h5>
                                <div>申請日:{{ \Carbon\Carbon::parse($reservation->created_at)->format('Y/m/d') }}</div>
                            </div>
                            <p class="font-weight-bold">
                                希望日：{{ \Carbon\Carbon::parse($reservation->date)->format('Y/m/d') }} {{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</p>
                        </div>
                        <input form="reservation-form" type="hidden" name="reservation-ids[]" class="js-reservation-id">
                        <input form="reservation-form" type="hidden" name="user-ids[]" class="js-user-id">
                    </div>
                @endforeach
                <form id="reservation-form" action="{{ route('reservation.update') }}" method="POST" class="mt-3">
                    @csrf
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-danger" name="status"
                                value="{{ \App\Constants\ReservationStatus::DECLINED }}">拒否
                        </button>
                        <button type="submit" class="btn btn-success ml-2" name="status"
                                value="{{ \App\Constants\ReservationStatus::APPROVED }}">承認
                        </button>
                    </div>
                </form>
            @else
                <div class="d-flex justify-content-center">まだ申請がありません。</div>
            @endif
        </div>
    </section>
@endsection
