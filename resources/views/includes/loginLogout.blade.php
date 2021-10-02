@if (session('logged_in') == 1)
<form align='right' action="/api/auth/logout" method="post">
    <button type="submit" class="btn btn-primary">Logout</button>
</form>
@else
<div align='right'>
    <a href="/login"><button> Login </button></a>
    <a href="/register"><button> Signup </button></a>
</div>
@endif