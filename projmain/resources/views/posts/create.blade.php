@extends('layouts.app')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Add new post</h2>
        <div class="lead">
            Add new post.
        </div>
        <div class="container mt-4">
            <form method="POST" action="{{ route('posts.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="text" class="form-label">Title</label>
                    <input value="{{ old('text') }}"
                        type="text" 
                        class="form-control" 
                        name="text" 
                        placeholder="Text" required>

                    @if ($errors->has('title'))
                        <span class="text-danger text-left">{{ $errors->first('text') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Add post</button>
                <a href="{{ route('posts.index') }}" class="btn btn-default">Back</a>
            </form>
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

    </div>
@endsection