@extends('layouts.base')

@section('content')
<section id="application-check">
    <h2 class="text-center mt-3">申請一覧</h2>
    <div class="container">
        <table class="table table-striped table-hover mt-3" style="white-space: nowrap;">
            <thead>
                <tr>
                    <th scope="col"><input type="checkbox" id="checkall"></th>
                    <td scope="col">ユーザーID</td>
                    <td scope="col">ユーザー名</td>
                    <td scope="col">申請日</td>
                    <td scope="col">コメント</td>
                    <td scope="col"></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><input type="checkbox" name="user_1" id="user_1"></th>
                    <td scope="row">{{ $user->id }}</td>
                    <td><a href="{{ route('profile.show', $user->id) }}" class="text-dark">{{ $user->name }}</a></td>
                    <td>{{ date('Y-m-d') }}</td>
                    <td><input type="text" name="comment" id=""></td>
                    <td class="text-right">
                        <button class="btn btn-danger">拒否</button>
                        <button class="btn btn-success">承認</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
@endsection