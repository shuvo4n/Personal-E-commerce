@extends('layouts.dashboard_app')

@section('category')
  active
@endsection

@section('dashboard_content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
      <span class="breadcrumb-item active">Category</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Category Page</h5>
        <p>This is a Category page</p>
      </div><!-- sl-page-title -->
    </div><!-- sl-pagebody -->

  <!-- ########## END: MAIN PANEL ########## -->

  {{-- MAIN PART --}}
<div class="container">
  <div class="row">
    <div class="col-md-9">
      <div class="card text-white bg-dark mb-8" style="max-width: 50rem;">
        <div class="card-header">List category (Active)</div>
        <div class="card-body">
          @if (session('delete_status'))
            <div class="alert alert-danger">
              <li>{{ session('delete_status') }}</li>
            </div>
          @endif
          <form method="post" action="{{ url('mark/delete') }}">
          @csrf
          <table class="table table-striped|bordered|hover|sm text-white" id="category_table">
            <thead>
              <tr>
                <th>MARK</th>
                <th>SL</th>
                <th>Category Name</th>
                <th>Category Description</th>
                <th>Created By</th>
                <th>Category Photo</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($categories as $category)
                <tr>
                  <td>
                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}" />
                  </td>
                  <td>{{ $loop->index + 1 }}</td>
                  <td>{{ $category->category_name }}</td>
                  <td>{{ $category->category_description }}</td>
                  <td>{{ App\User::find($category->user_id )->name}}</td>
                  <td>
                    <img src="{{ asset("uploads/category_photos") }}/{{ $category->category_photo }}" class="img-fluid" alt="category">
                  </td>
                  <td>{{ $category->created_at->diffForHumans() }}</td>
                  <td>
                  @isset($category->updated_at)
                    {{$category->updated_at->diffForHumans()}}
                  @endisset
                  </td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Button group">
                      <button  type="button" class="btn btn-info" onclick="window.location.href='{{ url('edit/category/') }}/{{ $category->id }} ' "> Edit</button>
                      <button type="button" class="btn btn-warning" onclick="window.location.href='{{ url('delete/category/') }}/{{ $category->id }} ' "> Delete </button>
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
          @if ($categories->count() > 0)
            <button  type="submit" class="btn btn-danger"> Mark Delete </button>
          @endif
        </form>
        </div>
      </div>

      <div class="card text-white bg-dark mb-8 mt-5" style="max-width: 40rem;">
        <div class="card-header bg-danger">List category (Deleted)</div>
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
          <form method="post" action="{{ url('mark/restore') }}">
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
              @forelse ($deleted_categories as $deleted_category)
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
                  </td>
                </tr>
              @empty
                  <tr>
                  <td colspan="50" class="text-center text-danger"></p>No Data available</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
            @if ($deleted_categories->count()>0)
              <button  type="submit" class="btn btn-success"> Mark Restore </button>
            @endif
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
          <div class="card-header">Add category</div>
          <div class="card-body">
                @if (session('success_status'))
                  <div class="alert alert-success">
                    {{ session('success_status') }}
                  </div>

                @endif
                @if ($errors->all())
                  <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                      <li> {{ $error }}</li>
                    @endforeach
                  </div>
                @endif
                    <form method="post" action="{{ url('add/category/post') }}" enctype="multipart/form-data">
                      @csrf
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Name</label>
                      {{-- {{ print_r($errors->all()) }} --}}
                      <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter Category Name" name="category_name" value="{{ old('category_name') }}">
                      @error('category_name')
                      <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Description</label>
                      {{-- {{ print_r($errors->all()) }} --}}
                      <textarea class="form-control" rows="8" name="category_description" > {{ old('category_description') }}</textarea>
                      @error('category_description')
                      <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Category Photo</label>
                      {{-- {{ print_r($errors->all()) }} --}}
                      <input class="form-control" type="file" name="category_photo" >
                      {{-- @error('category_description')
                      <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                      @enderror --}}
                    </div>
                    <button type="submit" class="btn btn-primary">Add Category</button>
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
