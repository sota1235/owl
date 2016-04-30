@if (!isset($needContainerDiv))
<div class="media comment">
@endif
  <a class="pull-left" href="{{{ route('user.profile', ['username' => $comment->user->username]) }}}">
    {!! HTML::gravator($comment->user->email, 40,'mm','g','true',array('class'=>'media-object')) !!}
  </a>
  <div class="media-body">
    <div class='left'>
      <div id="inside">
        <h4 class="media-heading title-username" ><a class="pull-left" href="{{{ route('user.profile', ['username' => $comment->user->username]) }}}">{{$comment->user->username}}</a></h4>
        <h4 class="media-heading title-onedit">コメントを編集する</h4>
      </div>
    </div>
    <div class="right">
      <div>{{{ date('Y/m/d H:i', strtotime($comment->updated_at)) }}}</div>

      <div>
        @if (isset($User) && $comment->user_id === $User->id)
        <a href="javascript:void(0)" class="start-edit">編集</a>・<a href="javascript:void(0)" class="comment-delete" value="anonakami">削除</a>
        @else
         　
        @endif
      </div>
    </div>
  </div>
  <div class="body">
    <div class="arrow_box">
    {!! HTML::markdown($comment->body) !!}
    </div>
    @if (isset($User) && $comment->user_id === $User->id)
    <div class="comment-edit">
      <div class="form">
      {!! Form::open(array('url'=>'comment/update', 'onsubmit' => 'return false;')) !!}
        {!! Form::hidden('comment-id', $comment->id, array('class' => 'comment-id')) !!}
        {!! Form::textarea('body', $comment->body ,array('class'=>'form-control comment-edit-body', 'rows'=>'5')) !!}
        {!! Form::hidden('orig_comment', $comment->body, array('class' => 'orig_comment')) !!}
      </div>
      <div class="button">
        {!! Form::button('キャンセル',array('class'=>'edit-cancel btn')) !!}
        {!! Form::submit('編集',array('class'=>'edit-confirm btn')) !!}
      </div>
    </div>
    @endif
      {!! Form::close() !!}
  </div>
@if (!isset($needContainerDiv))
</div>
@endif
