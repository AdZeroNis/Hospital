@extends('Auth.layout.master-part')

@section('content')
<div class="login-logo">
    <a href="../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <form action="{{route('FormLogin')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3">
            <input type="text" name="mobile" class="form-control" placeholder="Mobile" />
          <div class="input-group-text"><span class="bi bi-envelope"></span></div>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" />

          <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
        </div>


          <!-- /.col -->
          <div class="col-4">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary">Sign In</button>
            </div>
          </div>
          <!-- /.col -->
        </div>

      </form>

    <!-- /.login-card-body -->
  </div>

@endsection
