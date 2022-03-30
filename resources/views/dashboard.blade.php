@extends('app')
@section('content')
<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                    <li class="nav-item" id="login">
                        <a class="nav-link" href="{{route("login")}}" >Login</a>
                    </li>
                   <li class="nav-item" id="logout">
                       <a class="nav-link" onclick="
                       localStorage.removeItem('token');
                       window.location.href = '/';" >Logout</a>
                   </li>
            </ul>
        </div>
</nav>
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
    <button class="btn btn-primary" onclick="setDashboardContent()">Submit</button>
    <button class="btn btn-primary" onclick="refreshDashboardContent()">Refresh</button>
</div>

@endsection

