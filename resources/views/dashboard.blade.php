@extends('app')
@section('content')

<!-- list username, email, phone -->
<div class="container" id="content">
    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">Username</label>
            <input type="text" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter username">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Phone</label>
            <input type="text" class="form-control" id="phone" placeholder="Enter phone">
        </div>

    </form>
    <button class="btn btn-primary" onclick="setDashboardContent(this)">Submit</button>
    <button class="btn btn-primary" onclick="refreshDashboardContent(this)">Refresh</button>
    <button id="logout" class="btn btn-primary" onclick="
                       this.disabled = true;
                       localStorage.removeItem('token');
                       sessionStorage.removeItem('token');
                       window.location.href = '/';" >Logout</button>

</div>
<a id="login" class="btn btn-primary" href="{{route("login")}}" >Login</a>
@endsection

