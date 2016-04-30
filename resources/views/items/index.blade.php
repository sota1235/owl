@extends('layouts.master')

@section('title')
すべての投稿 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">すべての投稿</p>
@stop

@section('contents-main')
<div class="items">
    @foreach ($items as $item)
    <div class="item">
        {!! \HTML::gravator($item->email, 40) !!}
        <p><a href="{{{ route('user.profile', ['username' => $item->username]) }}}" class="username">{{{$item->username}}}</a>さんが<?php echo date('Y/m/d', strtotime($item->updated_at)); ?>に投稿しました。</p>
        <p><a href="{{{ route('items.show', ['items' => $item->open_item_id]) }}}"><strong>{{{ $item->title }}}</strong></a></p>
    </div>
    @endforeach
    {{{ $items->render() }}}
</div>
@stop

@section('contents-sidebar')
    @include('layouts.contents-sidebar')
@stop
