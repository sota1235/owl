@section('contents-sidebar')
@if(isset($User))
    <a href="{{{ route('items.create') }}}" class="btn btn-success btn-block">記事を投稿する</a>
    <div class="panel panel-default">
        <div class="panel-heading">テンプレートから作成 <a href="{{{ route('templates.index') }}}">[編集]</a></div>
        <ul class="list-group">
            @forelse ($templates as $template)
            <li class="list-group-item">
                <a href="{{{ route('items.create', ['t' => $template->id]) }}}">{{{$template->display_title}}}</a>
            </li>
            @empty
            <li class="list-group-item">
                <a href="{{{ route('templates.create') }}}"><span class="glyphicon glyphicon-plus"></span> 新しく作成する</a>
            </li>
            @endforelse
        </ul>
    </div>

    @if(!empty($ranking_stock))
        <h4>総合お気に入り数ランキング</h4>
        <div class="sidebar-info-items">
            <ol>
            @foreach ($ranking_stock as $item)
                <li><a href="{{ action('ItemController@show', $item->open_item_id) }}">{{{ $item->title }}}</a></li>
            @endforeach
            </ol>
        </div>
    @endif
@endif
@stop
