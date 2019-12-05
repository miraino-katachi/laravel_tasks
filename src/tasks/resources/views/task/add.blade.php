@extends('layouts.taskapp')

@section('title', '新規追加')

@section('content')
<form action="/task/add" method="post">
        {{ csrf_field() }}
        <table class="form"">
            <tr>
                <th>項目名</th>
                <td>
                    @if ($errors->has('task_name'))
                        <p class="warning">{{ $errors->first('task_name') }}</p>
                    @endif
                    <input type="text" name="task_name" class="form-control task-name" value="{{ old('task_name') }}">
                </td>
            </tr>
            <tr>
                <th>期限</th>
                <td>
                    @if ($errors->has('expire_date'))
                        <p class="warning">{{ $errors->first('expire_date') }}</p>
                    @endif
                    <input type="date" name="expire_date" class="form-control expire-date" value="{{ old('expire_date') }}">
                </td>
            </tr>
            <tr>
                <th>完了</th>
                <td><input type="checkbox" name= "finished_date" value="1" @if (old('finished_date') == 1) checked @endif
                ></td>
            </tr>
        </table>
        <input type="submit" class="btn btn-primary" value="追加">
    </form>

@endsection