@extends('layouts.dashboard_app')

@section('category')
  active
@endsection

@section('dashboard_content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ url('add/category') }}">Category</a>
      <span class="breadcrumb-item active">{{ $category_info->category_name }}</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Category Edit Page</h5>
        <p>Edit Category Here</p>
      </div><!-- sl-page-title -->

    </div><!-- sl-pagebody -->
  </div><!-- sl-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->

  {{-- MAIN PART --}}
<div class="container">
  <div class="row">
      <div class="col-md-4 m-auto">
        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
          <div class="card-header">Edit category</div>
          <div class="card-body">
                <ol class="breadcrumb">
                  <li><a href="{{ url('add/category') }}">Add category </a> </li>
                  <li class="text-dark">/  {{ $category_info->category_name }}</li>
                </ol>
                    <form method="post" action="{{ url('edit/category/post') }}">
                      @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Name</label>
                      {{-- {{ print_r($errors->all()) }} --}}
                      <input type="hidden" name="category_id" value="{{ $category_info->id }}">
                      <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter Category Name" name="category_name" value="{{ $category_info->category_name }}">
                      @error('category_name')
                      <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Description</label>
                      {{-- {{ print_r($errors->all()) }} --}}
                      <textarea class="form-control" rows="8" name="category_description" > {{ $category_info->category_description }}</textarea>
                      @error('category_description')
                      <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <button type="submit" class="btn btn-warning">Edit Category</button>
                  </form>
          </div>


      </div>
    </div>
  </div>
</div>
@endsection
