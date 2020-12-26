@extends('layouts.dashboard_app')

@section('title')
  IronMan|Dashboard
@endsection
@section('home')
  active
@endsection

@section('dashboard_content')
  <!-- ########## START: MAIN PANEL ########## -->
  <div class="sl-mainpanel">
    <nav class="breadcrumb sl-breadcrumb">
      <span class="breadcrumb-item active">Home</span>
    </nav>

    <div class="sl-pagebody">
      <div class="sl-page-title">
        <h5>Dashboard</h5>
        <p>This is a Dynamic Dashboard page</p>
      </div><!-- sl-page-title -->

    </div><!-- sl-pagebody -->
  </div><!-- sl-mainpanel -->
  <!-- ########## END: MAIN PANEL ########## -->

  {{-- MAIN PART --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                  <a href=' {{ url('send/newsletter') }}' class="btn btn-success">Send Newsletters to {{ $total_users }} </a>
                  <p> Queue is left</p>
            </div>
        </div>
      </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> Dashboard
                    <h1>Total Users: {{ $total_users }}</h1>
            </div>
        </div>
      </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- <h1 class="text-danger">You are logged in!</h1> --}}
                    {{-- <span class="text-danger">ok</span> --}}
                    @php
                        // print_r($users);
                    @endphp
                    <table class="table table-striped table-dark">
                      <thead>
                        <tr>
                          <th scope="col">SL.NO</th>
                          <th scope="col">Id</th>
                          <th scope="col">Name</th>
                          <th scope="col">E-Mail</th>
                          <th scope="col">Created at</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $user)
                        <tr>
                          {{-- <td>{{ $loop->index + 1}}</td> --}}
                          <td>{{ $users->firstItem() + $loop->index }}</td>
                          <td>{{ $user->id }}</th>
                          <td>{{ Str::title($user->name) }}</td>
                          <td>{{ $user->email }}</td>
                          <td>
                              <li>{{ $user->created_at->format('d/m/y') }}</li>
                              <li>{{ $user->created_at->format('h:i:s A') }}</li>
                              <li>{{ $user->created_at->timezone('UTC')->format('h:i:s A') }}</li>
                              <li>{{ $user->created_at->diffForHumans() }}</li>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                         {{ $users->links() }} {{-- {{ $next->links() }} --}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h1 class="text-danger">You are logged in!</h1> --}}
                    {{-- <span class="text-danger">ok</span> --}}
                    @php
                        // print_r($users);
                    @endphp
                    <table class="table table-striped table-dark">
                      <thead>
                        <tr>
                          <th scope="col">SL.NO</th>
                          <th scope="col">Name</th>
                          <th scope="col">E-Mail</th>
                          <th scope="col">Subject</th>
                          <th scope="col">Message</th>
                          <th scope="col">File</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($contacts as $contact)
                        <tr>
                          <td>{{ $loop->index + 1}}</td>
                          {{-- <td>{{ $contacts->firstItem() + $loop->index }}</td> --}}
                          {{-- <td>{{ $contact->id }}</th> --}}
                          <td>{{ Str::title($contact->contact_name) }}</td>
                          <td>{{ $contact->contact_email }}</td>
                          <td>{{ $contact->contact_subject }}</td>
                          <td>{{ $contact->contact_message }}</td>
                          <td>
                            @if ($contact->contact_attachment)
                              <a href="{{ url('contact/upload/download') }}/{{ $contact->id }}"><i class="fa fa-download"></i></a> |
                              <a target="_blank" href="{{ asset('storage') }}/{{ $contact->contact_attachment }}"><i class="fa fa-file"></i></a>
                            @endif

                          </td>
                          {{-- <td>
                              <li>{{ $user->created_at->format('d/m/y') }}</li>
                              <li>{{ $user->created_at->format('h:i:s A') }}</li>
                              <li>{{ $user->created_at->timezone('UTC')->format('h:i:s A') }}</li>
                              <li>{{ $user->created_at->diffForHumans() }}</li>
                          </td> --}}
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
