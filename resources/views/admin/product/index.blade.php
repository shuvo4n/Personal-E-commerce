{{-- <!-- @php
  error_reporting(0);
@endphp --> --}}
@extends('layouts.dashboard_app')

@section('product')
  active
@endsection

@section('dashboard_content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
      <span class="breadcrumb-item active">Product</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Product Page</h5>
        <p>This is a Product page</p>
      </div><!-- sl-page-title -->
    </div><!-- sl-pagebody -->

  <!-- ########## END: MAIN PANEL ########## -->

  {{-- MAIN PART --}}
<div class="container">
  <div class="row">
    <div class="col-md-9">
      <div class="card text-white bg-dark mb-8" style="max-width: 50rem;">
        <div class="card-header">List Product (Active)</div>
        <div class="card-body">
          @if (session('delete_status'))
            <div class="alert alert-danger">
              <li>{{ session('delete_status') }}</li>
            </div>
          @endif
          @if (session('product_edit_status'))
            <div class="alert alert-success">
              <li>{{ session('product_edit_status') }}</li>
            </div>
          @endif

          <table class="table table-striped|bordered|hover|sm text-white" id="category_table">
            <thead>
              <tr>
                <th>MARK</th>
                <th>SL</th>
                <th>Category Name</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Alert</th>
                <th>Product Photo</th>
                <!-- <th>Created At</th> -->
                <!-- <th>Updated At</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($products as $product)
                <tr>
                  <form method="post" action="{{ url('mark/delete/product') }}" id="mark_delete_form">
                  @csrf
                  <td>
                    <input type="checkbox" name="product_id[]" value="{{ $product->id }}" />
                  </td>
                  <td>{{ $loop->index + 1 }}</td>
                  {{-- <td>{{ App\Category::find($product->category_id)->category_name }}</td> --}}
                  <td>{{ $product->onetoone->category_name}}</td>
                  <td>{{ $product->product_name }}</td>
                  <td>{{ $product->product_price }}</td>
                  <td>{{ $product->product_quantity }}</td>
                  <td>{{ $product->product_alert_quantity }}</td>
                   {{-- <td>{{ App\User::find($category->user_id )->name}}</td>  --}}
                  <td>
                    <img class="img-fluid" src="{{ asset("uploads/product_photos") }}/{{ $product->product_thumbnail_photo }}"  alt="product" width="50" height="50">
                  </td>
                  <!-- <td>{{ $product->created_at->diffForHumans() }}</td>
                  <td>
                  @isset($product->updated_at)
                    {{$product->updated_at->diffForHumans()}}
                  @endisset
                  </td> -->
                  <td>
                    <div class="btn-group" role="group" aria-label="Button group">
                      <button  type="button" class="btn btn-info" onclick="window.location.href='{{ route('product.edit', $product->id) }}' "> Edit</button>
                    </form>
                      <form action="{{ route('product.destroy', $product->id) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-warning">Delete</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="50" class="text-center text-danger"></p>No Data available</td>
                </tr>
              @endforelse
            </tbody>
          </table>
          @if ($products->count() > 0)
            <button  type="submit" class="btn btn-danger" id="mark_delete_btn"> Mark Delete </button>
          @endif
        </div>
      </div>

      <div class="card text-white bg-dark mb-8 mt-5" style="max-width: 40rem;">
        <div class="card-header bg-danger">List Product (Deleted)</div>
        <div class="card-body">
          @if (session('restore_status'))
            <div class="alert alert-success">
              <li>{{ session('restore_status') }}</li>
            </div>
          @endif
          @if (session('force_delete_status'))
            <div class="alert alert-danger">
              <li>{{ session('force_delete_status') }}</li>
            </div>
          @endif
          <form method="post" action="{{ url('mark/restore/product') }}">
          @csrf
          <table class="table table-inverse|reflow|striped|bordered|hover|sm text-white">
            <thead>
              <tr>
                <th>MARK</th>
                <th>SL</th>
                <th>Category Name</th>
                <th>Category Description</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              {{-- @forelse ($deleted_categories as $deleted_category)
                <tr>
                  <td>
                    <input type="checkbox" name="category_id[]" value="{{ $deleted_category->id }}" />
                  </td>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{$deleted_category->category_name}}</td>
                  <td>{{$deleted_category->category_description}}</td>
                  <td>{{App\User::find($deleted_category->user_id)->name}}</td>
                  <td>{{$deleted_category->created_at->diffForHumans()}}</td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Button group">
                      <button  type="button" class="btn btn-success" onclick="window.location.href='{{ url('restore/category/') }}/{{ $deleted_category->id }} ' "> Restore </button>
                      <button type="button" class="btn btn-danger" onclick="window.location.href='{{ url('force/delete/category/') }}/{{ $deleted_category->id }} ' "> F.D. </button>
                    </div>
                  </td> --}}
                </tr>
              {{-- @empty
                  <tr>
                  <td colspan="50" class="text-center text-danger"></p>No Data available</td>
                  </tr>
                @endforelse --> --}}
              </tbody>
            </table>

        </form>
        </div>
      </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
          <div class="card-header">Add Product</div>
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
                    <form method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
                      @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Name</label>
                      <select class="form-control" name="category_id">
                        <option value="">--Select One--</option>
                        @foreach ($active_categories as $active_category)
                        <option value=" {{ $active_category->id }} "> {{ $active_category->category_name }} </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Name</label>
                        <input type="text" class="form-control" placeholder="Enter Category Name" name="product_name" value="{{ old('product_name') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Short Description</label>
                      <textarea class="form-control" rows="8" name="product_short_description" id="product_short_description"> {{ old('product_short_description') }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Long Description</label>
                      <textarea class="form-control" rows="8" name="product_long_description" id="product_long_description"> {{ old('product_long_description') }}</textarea>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Price</label>
                        <input type="text" class="form-control" placeholder="Enter Product Price" name="product_price" value="{{ old('product_price') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Quantity</label>
                        <input type="text" class="form-control" placeholder="Enter Product Quantity" name="product_quantity" value="{{ old('product_quantity') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Alert Quantity</label>
                        <input type="text" class="form-control" placeholder="Enter Alert Quantity" name="product_alert_quantity" value="{{ old('alert_quantity') }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Thumbnail Photo</label>
                      <input class="form-control" type="file" name="product_thumbnail_photo" >
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Product Multiple Photos</label>
                      <input class="form-control" type="file" name="product_multiple_photo[]" multiple >
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
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
    $(document).ready(function(){
      $('#mark_delete_btn').click(function(){
        $('#mark_delete_form').submit();
      });
      // ClassicEditor
      // .create( document.querySelector( '#product_short_description' ) )
      // .then( editor => {
      //         console.log( editor );
      // } )
      // .catch( error => {
      //         console.error( error );
      // } );
      // ClassicEditor
      // .create( document.querySelector( '#product_long_description' ) )
      // .then( editor => {
      //         console.log( editor );
      // } )
      // .catch( error => {
      //         console.error( error );
      // } );
    })
  </script>
@endsection
