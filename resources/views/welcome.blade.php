@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome') }}</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{url('/posts')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <textarea name="text" class="form-control" placeholder="write something..." rows="3" style="resize:none"></textarea>
                        </div>
                        
                        <input name="audio" type="file" id="attach_audio" accept="audio/x-mpeg" style="display:none"/>
                        
                        <button class="btn btn-secondary" type="button" onclick="document.getElementById('attach_audio').click()">attach audio</button>
                        <button class="btn btn-primary" type="submit" value="true" name="submit">Submit</button>
                    </form>
                    
                    <hr/>
                    
                    @forelse($posts as $post)
                    <div class="card mb-3">
                        <div class="card-body">
                            @if($post->text)
                            <p>{{$post->text}}</p>
                            @endif
                            
                            @if($post->file_attach)
                            <audio controls>
                                <source src="uploads/{{$post->file_attach}}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            @endif
                        </div>
                        <div class="card-footer">
                            <small><i> {{$post->created_at->diffForHumans()}}</i> by: <b>{{$post->user->name}}</b> <span class="float-right"></span></small>
                            
                            @auth
                            @if($post->user_id == Auth::user()->id)
                            <span class="float-right"><a href="{{url('/post/delete')}}/{{$post->id}}" class="btn-link text-danger" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash-alt"></i></a></span>
                            @endif
                            @endauth
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
