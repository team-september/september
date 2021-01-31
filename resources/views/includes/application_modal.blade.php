<!-- Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="applicationModalTitle">メンティー申請</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="applicationSelect">申請するメンターを選択してください。</label>
                    <select id="applicationSelect" form="applicationForm" class="form-control" name="mentor_id">
                        @foreach($mentors as $mentor)
                            <option value={{ $mentor->id }}>
                                {{" $mentor->name (@$mentor->nickname)"}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                <form id="applicationForm" action="{{ route('application.store') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary text-white">申請を確定</button>
                </form>
            </div>

        </div>
    </div>
</div>
