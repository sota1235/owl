<div class="media">
    <a class="pull-left" href="{{{ route('user.profile', ['username' => $User->username]) }}}">
    {!! HTML::gravator($User->email, 40, 'mm', 'g', 'true', ['class' => 'media-object']) !!}
  </a>
  <div class="media-body">
    <div>
      <div style="margin-top:10px"><h4 class="media-heading" style="font-weight:bold">コメントを投稿する</h4></div>
    </div>
  </div>
  <div style="margin-top:15px;margin-bottom:5px;">
    {!! Form::open(['url' => 'comment/create', 'class'=>'form-comments', 'id' => 'comment-form', 'onsubmit' => 'return false;']) !!}
        {!! Form::textarea('body', '' , ['class' => 'form-control', 'rows' => '5', 'id' => 'comment-text', 'placeholder' => 'コメントを入力して下さい。']) !!}
        {!! Form::hidden('open_item_id',$item->open_item_id) !!}
  </div>
  <div style="text-align:right">
        {!! Form::submit('投稿する', ['class' => 'btn js-comment-submit-btn']) !!}
    {!! Form::close() !!}
  </div>
</div>
