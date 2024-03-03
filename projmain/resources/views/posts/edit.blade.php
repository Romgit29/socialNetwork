@extends('layouts.app')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update post</h2>
        <div class="lead">
            Edit post.
        </div>

        <div class="container mt-4">
                
            <form method="POST" action="{{ route('posts.update', $post->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="text" class="form-text">text</label>
                    <input value="{{ $post->text }}" 
                        type="text" 
                        class="form-control" 
                        name="text" 
                        placeholder="Text" required>

                    @if ($errors->has('text'))
                        <span class="text-danger text-left">{{ $errors->first('text') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('posts.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection