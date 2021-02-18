@extends('layouts.base')

@section('content')
    {{--    @TODO:メンティーなら過去の応募内容、メンティーなら受け取った応募一覧を表示--}}
    <div class="text-center">
            @if (session('success'))
                <div class="alert alert-success text-center">
                    <ul class="list-unstyled">
                        <li>{{ session('success') }}</li>
                    </ul>
                </div>
            @endif
            @if (session('alert'))
                <div class="alert alert-danger text-center">
                    <ul class="list-unstyled">
                        <li>{{ session('alert') }}</li>
                    </ul>
                </div>
            @endif

        @if(!$coustomers)
            応募がありません
        @else
        <h1 class="my-3 ml-3">応募一覧</h1>
        
        @if($user_category!="mentor_id")
            <form action="{{ route('application.update') }}" method="POST">
                    @csrf
                    @method('POST')
                <div class="col-sm-8 offset-md-2">
                    承認する応募をチェックして、承認ボタンを押してください。
                </div>
                <div class="col-sm-6 offset-md-6">
                    <p><button type= "submit" class="btn btn-primary" 
                        name="approved" value="approved">承認</button>
                    </p>
                </div>
                <input type="hidden" name="mentor_id" value="{{$user_id}}">
        @endif

           @foreach($coustomers as $customer)
                    <div class ="col-sm-8 offset-md-2">
                        <div class="card">
                            <label>
                                <div class="card-body">
                                    <div class="text-left">
                                        @if($user_category!="mentor_id")
                                            <p><input type="checkbox" name="user_id[]" value= {{ $customer['id'] }}></p> 
                                        @endif
                                        名前： <a href="{{ route('profile.show',$customer['id'])}}" >{{ $customer['name']}}</a>
                                    </div>
                                    <div class="text-right">
                                        受付日: {{ $customer['created_at']}} 
                                    </div>
                                <div class="text-right">
                                    <button type= "submit" class="btn btn-dark pull-right" name="rejected" value="rejected">拒否</button>
                                </div>
                                <div class="text-left">
                                </div>
                            </lavel>
                        </div>
                    </div>
            @endforeach
        @endif
    </div>
    </form>
@endsection
