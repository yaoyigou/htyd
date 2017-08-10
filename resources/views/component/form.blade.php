<form action="{{$action}}" method="post" id="{{$id or ''}}"
      @if(isset($file)&&$file==true)enctype="multipart/form-data" @endif>
    @if(in_array($method,['post','delete','put']))
        {!! csrf_field() !!}
    @endif
    @if(in_array($method,['delete','put']))
        {{ method_field($method) }}
    @endif
    {{$slot}}
</form>