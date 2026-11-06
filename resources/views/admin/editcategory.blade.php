@extends('admin.maindesign')
@section('editcategory')

@if(session('success'))
    <div class="alert alert-success shadow p-4 rounded">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.updateCategory' , $category->id) }}" method="POST" class="container mt-4" enctype="multipart/form-data">
    @csrf

    <div class="card shadow p-4">
        <div class="d-flex justify-content-between">
            <h4 class="mb-4 text-primary">Update Category</h4>
        </div>
        <!-- Category Name -->
        <div class="mb-3">
            <label class="form-label">ឈ្មោះប្រភេទ</label>
            <input type="text" name="category_name" 
                   class="form-control" 
                   placeholder="បញ្ចូលឈ្មោះប្រភេទ" required value="{{$category->category}}">
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">ការពិពណ៌នា</label>
            <textarea name="description" class="form-control" rows="4" placeholder="បញ្ចូលការពិពណ៌នា (optional)">{{$category->description}}</textarea>
        </div>

        <!-- Image Upload -->
        <!-- Current Image -->
        <div class="mb-3">
            <label class="form-label">រូបភាពបច្ចុប្បន្ន</label>

            @if($category->image)
                <div class="mb-2">
                    <img src="{{ asset('uploads/' . $category->image) }}"
                        width="120"
                        height="120"
                        style="object-fit: cover;"
                        class="rounded border">
                </div>
            @endif

            <label class="form-label">ជ្រើសរើសរូបភាពថ្មី</label>
            <input type="file" name="image" class="form-control">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">ស្ថានភាព</label>
            <select name="status" class="form-control">
                <option value="{{$category->status}}">បង្ហាញ</option>
                <option value="{{$category->status}}">មិនបង្ហាញ</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>

    </div>
</form>

@endsection