<section>
    
    <article>
    <h2>About</h2>
        <p>
            {{ $charity->getPresenter()->description }}
        </p>
    </article>
    <h2>Contact Us</h2>
    <p>
        <h3>Address</h3>
        <address>
            {{ $charity->getPresenter()->address }}
        </address>
    </p>

</section>
