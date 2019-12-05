@extends('layouts.taskapp')

@section('title', 'タスク一覧')

@section('content')
    <div class="search">
        <form action="/task/search" method="post">
            {{ csrf_field() }}
            <input type="text" name="search" class="form-control" value="{{ $search }}">
            <input type="submit" value="🔍" class="btn">
        </form>
    </div>
    <table class="list">
        <tr>
            <th>項目名</th>
            <th>担当者</th>
            <th>登録日</th>
            <th>期限日</th>
            <th>完了日</th>
            <th>操作</th>
        </tr>
        @foreach ($tasks as $task)
            @php
                $class = '';
                if (!is_null($task->finished_date)) {
                    $class = 'completed';
                }
            @endphp
            <tr class="{{ $class }}">
                <td>{{ $task->task_name }}</td>
                <td>{{ $task->user->name }}</td>
                <td>{{ $task->registration_date }}</td>
                <td>{{ $task->expire_date }}</td>
                <td>{{ $task->finished_date }}</td>
                <td>
                    @php
                        $class = '';
                        if ($task->user_id != Auth::user()->id) {
                            $class = 'disabled';
                        } else {
                            $class = 'enabled';
                        }
                    @endphp
                    <button class="{{ $class }}" {{ $class }} onclick="location.href='/task/complete?id={{ $task->id }}';">完了</button>
                    <button class="{{ $class }}" {{ $class }} onclick="location.href='/task/edit?id={{ $task->id }}';">更新</button>
                    <button class="{{ $class }}" {{ $class }} onclick="location.href='/task/del?id={{ $task->id }}';">削除</button>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $tasks->links() }}

@endsection