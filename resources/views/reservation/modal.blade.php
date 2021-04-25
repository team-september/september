<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="reservationModalLabel">予約時間を選択してください</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="resetModal()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('reservation.submit')}}" method="POST" name="reservationForm">
        @csrf
        <input type="hidden" name="mentor_id" value="{{ $mentor_id }}">
        <div class="modal-body">
          <h6><b>予約日：<span class="js-date"></span></b></h6>
          <div class="form-group">
            <input id="date-input" type="text" class="form-control-plaintext" readonly name="date" value="">
          </div>
          <div id="radio-box" class="mb-2">
            <label><b>希望時間</b></label>
            <template id="radio-template">
              <div class="form-check time-select-radio">
                <input class="form-check-input" type="radio" name="time" id="" value="" required> 
                <label class="form-check-label" for=""></label>
              </div>
            </template>
          </div>
          <div class="modal-footer mt-1">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="resetModal()">閉じる</button>
            <button type="submit" class="btn btn-success" onclick="validate()">予約する</button>
          </div>
        </div>
      </form>
  </div>
</div>

@section('js')
<script>
// モーダル表示時にAJAXで表示内容を取得
function getModalContents(mentor_id, date) {
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }, 
    url: "{{url('/reservation/getAvailability')}}",
    type: 'post',
    dataType: 'json',
    timeout: 5000,
    data: {
        'mentor_id': mentor_id,
        'date': date,
    }
  })
  .done((data) => {
      const date = Object.keys(data)[0]; // キーになっている日付を取得
      const times = data[date];          // 日付の配列に入っている時間を取得
      const parent = $('#radio-box');    // ラジオボタンを追加する親要素
      
      // 日付を入力
      $('#date-input').val(date);
      
      // templateタグ内のDOMを利用して時間のラジオボタン生成
      for(const time of times) {
        const div = $($('#radio-template').html());
        // ラジオボタン生成
        const inputRadio = generateTimeSelector(div, time);
        // 生成したDOMを親要素に追加
        parent.append(inputRadio);
      }
  })
  .fail(function() {
      alert('通信に失敗しました');
  });
}

// ラジオボタン生成
function generateTimeSelector(div, time) {
    // input要素生成
    const input = $('input', div).val(time).attr('id', time);
    div.append(input);

    // Label要素
    const label = $('label', div);
    label.attr('for', time).text(time);
    div.append(label);

    return div;
}

// モーダルクローズ時に追加した初期状態へ戻す
function resetModal() {
  $('#date-input').val();
  $('.time-select-radio').remove();
}
</script>
@endsection