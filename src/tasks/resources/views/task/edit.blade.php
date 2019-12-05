@extends('layouts.taskapp')

@section('title', 'タスク編集')

@section('content')
<form action="/task/edit" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ $task->id }}">
        <table class="form">
            <tr>
                <th>項目名</th>
                <td>
                    @if ($errors->has('task_name'))
                        <p class="warning">{{ $errors->first('task_name') }}</p>
                    @endif
                    @php
                        $value = $task->task_name;
                        if (old('task_name')) {
                            $value = old('task_name');
                        }
                    @endphp
                    <input type="text" name="task_name" class="form-control task-name" value="{{ $value }}">
                </td>
            </tr>
            <tr>
                <th>期限</th>
                <td>
                    @if ($errors->has('expire_date'))
                        <p class="warning">{{ $errors->first('expire_date') }}</p>
                    @endif
                    @php
                        $value = $task->expire_date;
                        if (old('expire_date')) {
                            $value = old('expire_date');
                        }
                    @endphp
                    <input type="date" name="expire_date" class="form-control expire-date" value="{{ $task->expire_date }}">
                </td>
            </tr>
            <tr>
                <th>完了</th>
                @php
                    $checked = '';
                    if (old('expire_date') || $task->finished_date) {
                        $checked = ' checked';
                    }
                @endphp
                <td><input type="checkbox" name= "finished_date" value="1"{{ $checked }}></td>
            </tr>
        </table>
        <input type="submit" class="btn btn-primary" value="更新">
        <input type="button" class="btn btn-primary" value="キャンセル" onclick="location.href='/task';">
    </form>

@endsection