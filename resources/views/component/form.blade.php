<form action="{{$action}}" method="{{$method}}" id="{{$id or ''}}"
      @if(isset($file)&&$file==true)enctype="multipart/form-data" @endif>
    @if(in_array($method,['post','delete','put']))
        {!! csrf_field() !!}
    @endif
    {{$slot}}
</form>