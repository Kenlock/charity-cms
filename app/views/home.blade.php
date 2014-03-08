<h2>Welcome</h2>

<p>
    Welcome to Altruisco.org! We are a non-profit charity website hosting service.
    <div class="media-item reverse">
        <figure class="media-content">
            {{ HTML::image('css/images/dashboard.png', 'Dashboard Preview') }}
        </figure>
        <section class="media">
            <h3>Popular Charities</h3>
            @include('widgets._popular_charities')
        </section>
    </div>
</p>


<h2>By using our service you can:</h2>
<p>
    <ul>
        <li>Create multiple charity websites</li>
        <li>Create posts for your users to read</li>
        <li>Comment and interact with your users</li>
        <li>Accept donations for your charity</li>
    </ul>
</p>

<h2>Get Started</h2>
<p>
    Head on over to the {{ HTML::link('users/register', 'registration') }} page
    to get started, and create your charity website.
</p>
<p>
    Or checkout the charities who have already made Altruisco.org their home
    over on the {{ HTML::link('c', 'discovery') }} page.
</p>
<p>
    {{ HTML::link('users/register', 'Register', array('class' => 'btn')) }}
    {{ HTML::link('c', 'Discover', array('class' => 'secondary-btn')) }}
</p>
