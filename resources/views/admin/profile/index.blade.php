@extends('layouts.dashboard_app')

@section('title')
  IronMan|Profile
@endsection

@section('dashboard_content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <a class="breadcrumb-item" href="{{ url('home') }}">Home</a>
      <span class="breadcrumb-item active">Profile</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Profile Page</h5>
        <p>This is a profile page</p>
      </div><!-- sl-page-title -->

    {{-- </div><!-- sl-pagebody -->
  </div><!-- sl-mainpanel --> --}}
  <!-- ########## END: MAIN PANEL ########## -->

  {{-- MAIN PART --}}
  <div class="container">
    <div class="row">
        <div class="col-md-6 ">
          <div class="card text-white bg-dark mb-4" style="max-width: 18rem;">
            @if (session('name_change_status'))
                <div class="alert alert-success">
                  <li>{{ session('name_change_status') }}</li>
                </div>
            @endif
            @if (session('name_error'))
                <div class="alert alert-success">
                  <li>{{ session('name_error') }}</li>
                </div>
            @endif
            @error ('name')
              <div class="alert alert-danger">
                  <li>{{ $message }}</li>
              </div>
            @enderror
            <div class="card-header">Edit Profile Name</div>
            <div class="card-body">
                      <form method="post" action="{{ url('edit/profile') }}">
                        @csrf
                      <div class="form-group">
                        <label for="exampleInputEmail1">Profile Name</label>
                        <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter Category Name" name="name" value="{{ Auth::user()->name }}">
                      </div>
                      </div>
                      <button type="submit" class="btn btn-warning">Edit Profile</button>
                    </form>
            </div>
          <div class="card text-white bg-dark mb-4" style="max-width: 18rem;">
            {{-- @if ($errors->all())
                <div class="alert alert-success">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </div>
            @endif --}}
            @error ('profile_photo')
              <div class="alert alert-danger">
                  <li>{{ $message }}</li>
              </div>
            @enderror
            <div class="card-header">Change Profile photo</div>
            <div class="card-body">
                      <form method="post" action="{{ url('change/profile/photo') }}" enctype="multipart/form-data">
                        @csrf
                      <div class="form-group">
                        <label for="exampleInputEmail1">Profile Photo</label>
                        <input type="file" class="form-control" name="profile_photo" onChange="readUrl(this);">
                        <img class="hidden" id="tenant_photo_viewer" src="#" alt="image" />
                        <script>
                        function readUrl(input){
                          if (input.files && input.files[0]){
                          var reader = new FileReader();
                          reader.onload = function (e) {
                            $('#tenant_photo_viewer').attr('src', e.target.result).width(250).height(195);
                          };
                          $('#tenant_photo_viewer').removeClass('hidden');
                            reader.readAsDataURL(input.files[0]);
                        }
                      }
                        </script>
                      </div>
                      </div>
                      <button type="submit" class="btn btn-info">Change Profile Photo</button>
                    </form>
            </div>
        </div>
        <div class="col-md-6 ">
          <div class="card text-white bg-dark mb-4" style="max-width: 18rem;">
            @error ('password')
                <div class="alert alert-danger">
                  <li>{{ $message }}</li>
                </div>
            @enderror
            <div class="card-header bg-success">Edit Password</div>
            <div class="card-body">
                      <form method="post" action="{{ url('edit/password') }}">
                        @csrf
                      <div class="form-group">
                        <label for="exampleInputEmail1">Old Password</label>
                        <input type="password" class="form-control" aria-describedby="emailHelp" placeholder="Enter old password" name="old_password" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">New Password</label>
                        <input type="password" class="form-control" aria-describedby="emailHelp" placeholder="Enter new password" name="password" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Confirm Password</label>
                        <input type="password" class="form-control" aria-describedby="emailHelp" placeholder="Enter Confirm password" name="password_confirmation">
                      </div>
                      </div>
                      <button type="submit" class="btn btn-warning">Edit Profile</button>
                    </form>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
