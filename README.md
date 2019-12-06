# 【Laravel】共有TODOリスト

## 課題の対象の方
秀和システム「PHPフレームワーク・Laravel入門」を学習済みの方を対象にしています。

## 動作環境
PHP 7.3、Laravel 5.5、MySQL 5.7で動作確認しています。

## Laravel 5.5のインストール方法
composer create-project "laravel/laravel=5.5.*" [プロジェクト名] --prefer-dist

## ログイン認証について
ログイン認証は、Laravelの認証機能を、ほとんどそのまま使っています。
下記のコードを編集します。

### App\Http\Controllers\Auth\LoginController
```
    // protected $redirectTo = '/home';
    protected $redirectTo = '/task';    // リダイレクト先を変更

    //下記を追記（ログアウト処理）
    public function logout()
    {
        $this->guard()->logout();
        return redirect('/login');    // リダイレクト先を変更
    }
```
### App\Http\Controllers\Auth\RegisterController
```
    // protected $redirectTo = '/home';
    protected $redirectTo = '/task';
```
### App\Http\Middleware\RedirectIfAuthenticated
```
// return redirect('/home');
    return redirect('/task');    // リダイレクト先を変更
```
