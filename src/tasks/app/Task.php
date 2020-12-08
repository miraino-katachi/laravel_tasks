<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** ガードするフィールド */
    protected $guarded = array('id');

    /** バリデーションルール */
    public static $rules = [
        'task_name' => 'required|max:50',
        'expire_date' => 'required|date',
    ];

    /** カスタマイズしたバリデーションエラーメッセージ */
    public static $messages = [
        'task_name.required' => '項目名を入力してください。',
        'task_name.max' => '項目名は、50文字以内で入力してください。',
        'expire_date.required' => '期限日を入力してください。',
        'expire_date.date' => '期限日には正しい日付を入力してください。',
    ];

    /**
     * リレーション
     * belongs toのときは、メソッド名は単数形にする。
     * @return void
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
