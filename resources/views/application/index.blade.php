@extends('layouts.base')

@section('content')
    {{--    @TODO:メンティーなら過去の応募内容、メンティーなら受け取った応募一覧を表示--}}
    <div class="text-center">
        @if($applications->isEmpty())
            応募がありません
        @else
        <h1 class="my-3 ml-3">応募一覧</h1>
        <div class="col-10 ml-10 mx-auto">
        <table class="table table-striped">
            <tbody>
                @foreach($coustomers as $customer)
                <tr>
                    <td>
                        <div class="text-left">
                            <a href="{{ route('profile.show',$customer['id'])}}" >{{ $customer['name']}}</a>
                        </div>
                        <div class="text-right">
                            <button type= "button" class="btn btn-primary">承認</button>
                            <button type= "button" class="btn btn-dark pull-right">拒否</button>
                        </div>
                        <div class="text-left">
                            {{ $customer['created_at']}}
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
@endsection
