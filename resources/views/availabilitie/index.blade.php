@extends('layouts.base')

@section('content')
<div class="text-center">
<h1 class="my-3 ml-3">スケジュール設定</h1>
<form>
<br>
<form action="" method="POST">
@csrf
@method('POST')

<div class ="col-sm-8 offset-md-2">
@for($i = 0; $i < 5; $i++)
        <div class="card bg-light mb-3">
        <label>
            <div class="text-left">
            <p><input type="checkbox" name=name.$i value= $i></div>
                <div class="card-text">
                <input type="date" name="tm01"></div>
                <div class="card-body">
                <input type="time" value="19:00">~<input type="time" name="tm03" value="23:00">
                </div>
            </div>
        </label>
        </br>
@endfor
</div>
<div class="col-sm-6 offset-md-6">
    <p><button type= "submit" class="btn btn-primary" 
        name="approved" value="approved">承認</button>
    </p>
</div>

</form>

@endsection
