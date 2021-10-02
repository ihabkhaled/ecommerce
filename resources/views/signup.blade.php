<form action="/api/auth/register" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
    </div>
    <div class="form-group">
        <label for="full_name">Full Name</label>
        <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Full Name">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Mobile</label>
        <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile">
    </div>
    <div class="form-group">
        <label for="full_name">Store Name</label>
        <input type="text" class="form-control" id="store_name" name="store_name" placeholder="Store Name">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>