@extends('layouts.taskapp')
@section('css')
<link rel="stylesheet" href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.structure.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/jquery-ui-1.12.1/jquery-ui.theme.min.css') }}">
@endsection
@section('title', 'タスク一覧')

@section('content')
    <div class="search">
        <form action="/task/search" method="get">
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
                if (strtotime($task->expire_date) < time()) {
                    $class = 'expired';
                }
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
                <td class="ope">
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
                    <button class="{{ $class }}" {{ $class }} onclick="deleteTask({{ $task->id }}, '{{ $task->task_name }}');">削除</button>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $tasks->appends(Request::only('search'))->links() }}

@endsection
@section('script')
<script src="{{ asset('js/jquery-ui-1.12.1/external/jquery/jquery.js') }}"></script>
<script src="{{ asset('js/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>
<script>
$(function() {
    $( "#dialog-confirm"　).hide();
});
function deleteTask(id, task) {
    $( "#task-delete"　).text(task);
    $( "#dialog-confirm" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
        buttons: {
            "削除": function() {
                $( this ).dialog( "close" );
                location.href='/task/del?id=' + id;
            },
            "キャンセル": function() {
            $( this ).dialog( "close" );
            }
        }
    });
}
</script>
<div id="dialog-confirm" title="削除"">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
        下記のタスクを削除してもいいですか？<br>
        <p id="task-delete"></p>
    </p>
</div>
@endsection