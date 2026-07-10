@extends('admin.layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h4 class="page-title">Add Blog</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Title <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="title" value="{{ old('title') }}" required>
                        @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input class="form-control" type="text" name="slug" value="{{ old('slug') }}" placeholder="Leave blank to auto-generate">
                        @error('slug')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <select class="form-control" name="user_id">
                            <option value="">Select Author</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <input class="form-control" type="text" name="category" value="{{ old('category') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tags (comma separated)</label>
                                <input class="form-control" type="text" name="tags" value="{{ old('tags') }}" placeholder="e.g. health, medical, treatment">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Excerpt</label>
                        <textarea class="form-control" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Content <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="content" rows="8" required>{{ old('content') }}</textarea>
                        @error('content')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label>Featured Image</label>
                        <input type="file" class="form-control-file" name="featured_image" accept="image/*">
                        @error('featured_image')<span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" required>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Published Date</label>
                                <input class="form-control" type="date" name="published_at" value="{{ old('published_at') }}">
                                @error('published_at')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="m-t-20 text-center">
                        <button class="btn btn-primary submit-btn">Create Blog</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection