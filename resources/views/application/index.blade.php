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
                <thead>
                    <tr>
                        <th>受付日</th>
                        <th>名前</th>
                        <th>承諾</th>
                        <th>拒否</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coustomers as $customer)
                    <tr>
                        <td>{{ $customer['created_at']}}</td>
                        <td><a href="" >{{ $customer['name']}}</td>
                        <td><button type= "button" class="btn btn-primary">承認</button></td>
                        <td><button type= "button" class="btn btn-dark">拒否</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
@endsection
