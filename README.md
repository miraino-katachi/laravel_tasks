# 【Laravel】共有TODOリスト
Laravel 5.5で動作確認しています。

作成中です・・・

## ログイン認証について
ログイン認証は、Laravelの認証機能を使っています。
下記のコードを編集します。

### App\Http\Controllers\Auth\LoginController
    // protected $redirectTo = '/home';
    protected $redirectTo = '/task';    // リダイレクト先を変更

    //下記を追記（ログアウト処理）
    public function logout()
    {
        $this->guard()->logout();
        return redirect('/login');    // リダイレクト先を変更
    }

### App\Http\Controllers\Auth\RegisterController
    // protected $redirectTo = '/home';
    protected $redirectTo = '/task';

### App\Http\Middleware\RedirectIfAuthenticated
    // return redirect('/home');
    return redirect('/task');    // リダイレクト先を変更
