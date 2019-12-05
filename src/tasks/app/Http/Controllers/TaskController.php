<?php

namespace App\Http\Controllers;

use App\Task;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * インデックスページ
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        // レコード抽出、ペジネーションで10件ずつ表示
        $tasks = Task::with('user')
                ->orderBy('expire_date', 'asc')
                ->paginate(10);
        $data = ['tasks' => $tasks];
        return view('task.index', $data);
    }

    /**
     * 新規追加ページ
     *
     * @param Request $request
     * @return void
     */
    public function add(Request $request)
    {
        return view('task.add');
    }

    /**
     * 新規追加処理
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        // バリデーション
        $this->validate($request, Task::$rules, Task::$messages);

        // 新規Taskモデルオブジェクト作成
        $task = new Task();

        // リクエストの内容をすべて取得
        $form = $request->all();

        // ユーザーIDはログインユーザーのID
        $form['user_id'] = Auth::user()->id;

        // 今日の日付オブジェクトを作成
        $today = new DateTime();

        // 登録日は今日にする
        $form['registration_date'] = $today->format('Y-m-d');

        if (isset($request->finished_date) && $request->finished_date == "1") {
            // フォームの「完了」にチェックが入っていたら、完了日は今日の日付にする
            $form['finished_date'] = $today->format('Y-m-d');
        } else {
            // フォームの「完了」にチェックが入っていなかったら、完了日はnullにする
            $form['finished_date'] = null;
        }

        // レコードを新規作成
        $task->fill($form)->save();

        // 一覧表示へリダイレクト
        return redirect('/task');
    }

    /**
     * 編集ページ
     *
     * @param Request $request
     * @return void
     */
    public function edit(Request $request)
    {
        // 該当のIDでログインユーザーのTaskを検索
        $task = Task::where('id', $request->id)
                ->where('user_id', Auth::user()->id)
                ->first();

        if (is_null($task)) {
            // レコードが無いときは、一覧ページにリダイレクト
            return redirect('/task');
        }

        $data = ['task' => $task];

        return view('task.edit', $data);
    }

    /**
     * 更新処理
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        // バリデーション
        $this->validate($request, Task::$rules, Task::$messages);

        // 該当のID、ログインユーザーのIDのレコードを検索
        $task = Task::where('id', $request->id)
                ->where('user_id', Auth::user()->id)
                ->first();

        if (is_null($task)) {
            // 該当レコードが存在しないときは、一覧ページへリダイレクト
            return redirect('/task');
        }

        // リクエストの内容をすべて取得
        $form = $request->all();

        if (isset($request->finished_date) && $request->finished_date == "1") {
            // フォームの「完了」にチェックが入っているときは、完了日を今日の日付にする
            $today = new DateTime();
            $form['finished_date'] = $today->format('Y-m-d');
        } else {
            // フォームの「完了」にチェックが入っていないときは、完了日をnullにする
            $form['finished_date'] = null;
        }

        // レコードをアップデート
        $task->fill($form)->save();

        return redirect('/task');
    }

    /**
     * 削除ページ
     *
     * @param Request $request
     * @return void
     */
    public function del(Request $request)
    {
        // 該当のIDでログインユーザーのTaskを検索
        $task = Task::where('id', $request->id)
                ->where('user_id', Auth::user()->id)
                ->first();

        if (is_null($task)) {
            // レコードが無いときは、一覧ページにリダイレクト
            return redirect('/task');
        }

        $data = ['task' => $task];

        return view('task.del', $data);
    }

    /**
     * 削除処理
     *
     * @param Request $request
     * @return void
     */
    public function remove(Request $request)
    {
        // 該当のIDでログインユーザーのTaskを検索して削除
        Task::where('id', $request->id)
                ->where('user_id', Auth::user()->id)
                ->delete();

        return redirect('/task');
    }

    /**
     * 完了処理
     *
     * @param Request $request
     * @return void
     */
    public function complete(Request $request)
    {
        // 該当のIDでログインユーザーのTaskを検索
        $task = Task::where('id', $request->id)
                ->where('user_id', Auth::user()->id)
                ->first();

        if (is_null($task)) {
            // レコードが無いときは、一覧ページにリダイレクト
            return redirect('/task');
        }

        if (is_null($task->finished_date)) {
            // レコードの完了日がnullのときは、完了日を今日の日付にする
            $today = new DateTime();
            $form['finished_date'] = $today->format('Y-m-d');
        } else {
            // 完了日がnullでないときは、完了日をnullにする
            $form['finished_date'] = null;
        }

        // レコードをアップデート
        $task->fill($form)->save();

        return redirect('/task');
    }
}
