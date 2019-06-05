@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="card ">

                <div class="card-body">
                    <h2 class="">
                        <i class="far fa-edit"></i>
                        @if($topic->id)
                            編輯話題
                        @else
                            建立話題
                        @endif
                    </h2>

                    <hr>

                    @if($topic->id)
                        <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            @else
                                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    @include('shared._error')

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="title"
                                               value="{{ old('title', $topic->title ) }}" placeholder="請填寫標題" required/>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" name="category_id" required>
                                            <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>請選擇分類</option>
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : '' }}>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" name="category_id" required>
                                            <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>請選擇 Channel</option>
                                            @foreach ($channels as $channel)
                                                <option value="{{ $channel->id }}" {{ $topic->channel_id == $channel->id ? 'selected' : '' }}>
                                                    {{ $channel->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <textarea name="body" class="form-control" id="editor" rows="6"
                                                  placeholder="至少填寫3個字元。"
                                                  required>{{ old('body', $topic->body ) }}</textarea>
                                    </div>

                                    <div class="well well-sm">
                                        <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 送出 </button>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop

@section('scripts')
    <script type="text/javascript" src="{{ asset('js/module.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/hotkeys.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/uploader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/simditor.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            var editor = new Simditor({
                textarea: $('#editor'),
                upload: {
                    url: '{{ route('topics.upload_image') }}',
                    params: {
                        _token: '{{ csrf_token() }}'
                    },
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                },
                pasteImage: true,
            });
        });
    </script>
@stop
