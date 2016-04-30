@extends('layouts.master')

@section('title')
タグ一覧 | Owl
@stop

@section('navbar-menu')
    @include('layouts.navbar-menu')
@stop

@section('contents-pagehead')
<p class="page-title">タグ一覧</p>
@stop

@section('contents-main')

<div class="page-header">
    <h5>人気のタグ</h5>
</div>

<div class="tags">
    <ul class="list-group">
        @foreach ($tags as $tag)
        <li class="list-group-item">
            <span class="badge">{{ $tag->count }}</span>
            <p class="list-group-item-heading"><span class="tag-label"><a href="{{{ route('tags.show', ['tags' => $tag->name]) }}}">{{ $tag->name }}</a></span></p>
            <p class="list-group-item-text">　<a href="{{{ route('items.show', ['items' => $tag->open_item_id]) }}}">{{ $tag->title }}</a></p>
        </li>
        @endforeach
    </ul>
</div>

@stop

@section('contents-sidebar')
    @if(!empty($recent_ranking))
        <h4>最新お気に入り数ランキング</h4>
        <div class="sidebar-info-items">
            <ol>
            @foreach ($recent_ranking as $item)
                <li><a href="{{{ route('items.show', ['items' => $item->open_item_id]) }}}">{{{ $item->title }}}</a></li>
            @endfor
            </ol>
        </div>
    @endif

    @if(!empty($all_ranking))
        <h4>総合お気に入り数ランキング</h4>
        <div class="sidebar-info-items">
            <ol>
            @for ($all_ranking as $item)
                <li><a href="{{{ route('items.show', ['items' => $item->open_item_id]) }}}">{{{ $item->title }}}</a></li>
            @endfor
            </ol>
        </div>
    @endif
@stop
