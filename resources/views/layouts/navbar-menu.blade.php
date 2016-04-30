@section('navbar-menu')
@if(isset($User))
<ul class="nav navbar-nav navbar-right">
    <li><a href="{{{ route('items.create') }}}">投稿する</a></li>
    <li><a href="{{{ route('favorites.index') }}}">お気に入り一覧</a></li>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{!! HTML::gravator($User->email, 20) !!}<span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{{ route('user.profile', ['username' => $User->username]) }}}">マイページ</a></li>
            <li><a href="{{{ route('user.edit.form') }}}">ユーザ情報変更</a></li>
@if($User->role == Owl\Services\UserRoleService::ROLE_ID_OWNER)
            <li><a href="{{{ route('admin') }}} ">管理画面</a></li>
@endif
            <li class="divider"></li>
            <li><a href="{{{ route('logout') }}}">ログアウト</a></li>
        </ul>
    </li>
</ul>
@else
<ul class="nav navbar-nav navbar-right">
    <li><a href="{{{ route('signup') }}}">新規登録</a></li>
    <li><a href="{{{ route('login.form') }}}">ログイン</a></li>
</ul>
@endif
@stop
