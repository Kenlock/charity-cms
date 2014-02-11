<ul class="login-nav">
    @if (Auth::guest())
        <li>{{ HTML::link('users/login', 'Login') }}</li>
        <li>{{ HTML::link('users/register', 'Register') }}</li>
    @else
        <li>{{ HTML::link('users/dashboard', 'Dashboard') }}</li>
        <li>{{ HTML::link('users/logout', 'Logout') }}</li>
    @endif
</ul>
