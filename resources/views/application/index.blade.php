@extends('layouts.base')

@section('content')
    {{--    @TODO:メンティーなら過去の応募内容、メンティーなら受け取った応募一覧を表示--}}
    <div class="text-center">
        @if($applications->isEmpty())
            応募がありません
        @else
        <h1 class="my-3 ml-3">応募一覧</h1>
                        @foreach($coustomers as $customer)
                            <div class="card col-9  mx-auto">
                                <div class="card-body">
                                    名前： <a href="{{ route('profile.show',$customer['id'])}}" >{{ $customer['name']}}</a>
                                </div>
                                <div class="card-footer">
                                    <button type= "button" class="btn btn-primary">承認</button>
                                    <button type= "button" class="btn btn-dark pull-right">拒否</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
            </div>
        @endif
    </div>
@endsection
