@extends('layouts.master')

@section('title')
Owl | TOP
@stop

@section('navbar-menu')
  @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">情報を共有しよう。</p>
@stop

@section('contents-main')
<ul class="nav nav-tabs nav-justified">
    <li role="presentation" @if($kind === 'stock') class="active" @endif><a href="{{{ route('index', ['kind' => 'stock']) }}}">ストック</a></li>
    <li role="presentation" @if($kind === 'flow') class="active"  @endif><a href="{{{ route('index', ['kind' => 'flow']) }}}">フロー</a></li>
    <li role="presentation" @if($kind === 'all') class="active"   @endif><a href="{{{ route('index', ['kind' => 'all']) }}}">全ての投稿</a></li>
</ul>

<div class="items">
  @forelse ($items as $item)
  <div class="item">
    {!! \HTML::gravator($item->email, 40) !!}
    <p><a href="{{{ route('user.profile', ['username' => $item->username]) }}}" class="username">{{{$item->username}}}</a>さんが{{{ date('Y/m/d', strtotime($item->updated_at)) }}}に投稿しました。</p>
    <p><a href="{{{ route('items.show', ['items' => $item->open_item_id]) }}}"><strong>{{{ $item->title }}}</strong></a></p>
  </div>
  @empty
    <br>
    <div class="center-block">
      <p class="text-center text-muted"><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> 表示する投稿がありません。<br>フロータグは管理画面から設定できます。</p>
    </div>
  @endforelse
<?php echo $items->appends(['kind' => $kind])->render(); ?>
</div>
@stop

@section('contents-sidebar')
  @include('layouts.contents-sidebar')
@stop
