<!-- @php
  error_reporting(0);
@endphp -->
@extends('layouts.dashboard_app')

@section('product')
  active
@endsection

@section('dashboard_content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
      <a class="breadcrumb-item" href="{{ route('product.index') }}">Product</a>
      <span class="breadcrumb-item active">{{ $product_info->product_name }}</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Product Edit Page</h5>
        <p>This is a Product Edit page</p>
      </div><!-- sl-page-title -->
    </div><!-- sl-pagebody -->

  <!-- ########## END: MAIN PANEL ########## -->

  {{-- MAIN PART --}}
<div class="container">
  <div class="row">
    <div class="col-md-6 m-auto">
        <div class="card text-white bg-dark">
          <div class="card-header">Edit Product</div>
          <div class="card-body">
                @if (session('product_status'))
                  <div class="alert alert-success">
                    {{ session('product_status') }}
                  </div>

                @endif
                @if ($errors->all())
                  <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                      <li> {{ $error }}</li>
                    @endforeach
                  </div>
                @endif
                    <form method="post" action="{{ route('product.update', $product_info->id) }}" enctype="multipart/form-data">
                      @csrf
                      @method('PATCH')
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Name</label>
                      <select class="form-control" name="category_id">
                        <option value="">--Select One--</option>
                        @foreach ($active_categories as $active_category)
                        <option {{ ($active_category->id == $product_info->category_id) ? "SELECTED":""  }} value=" {{ $active_category->id }} "> {{ $active_category->category_name }} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Name</label>
                        <input type="text" class="form-control" placeholder="Enter Product Name" name="product_name" value="{{ $product_info->product_name }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Short Description</label>
                      <textarea class="form-control" rows="8" name="product_short_description" > {{ $product_info->product_short_description }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Short Description</label>
                      <textarea class="form-control" rows="8" name="product_long_description" > {{ $product_info->product_long_description }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Price</label>
                        <input type="text" class="form-control" placeholder="Enter Product Price" name="product_price" value="{{ $product_info->product_price }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Quantity</label>
                        <input type="text" class="form-control" placeholder="Enter Product Quantity" name="product_quantity" value="{{ $product_info->product_quantity }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Alert Quantity</label>
                        <input type="text" class="form-control" placeholder="Enter Alert Quantity" name="product_alert_quantity" value="{{ $product_info->product_alert_quantity }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Photo</label>
                      <input class="form-control" type="file" name="product_photo" >
                    </div>
                    <button type="submit" class="btn btn-primary">Edit Product</button>
                  </form>
          </div>


      </div>
    </div>
  </div>
</div>

@endsection

@section('footer_scripts')
  <script type="text/javascript">
    $('#category_table').DataTable({
    // responsive: true,
    language: {
      searchPlaceholder: 'Search...',
      sSearch: '',
      lengthMenu: '_MENU_ items/page',
    }
    });
  </script>
@endsection
