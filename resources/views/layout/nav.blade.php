<nav class="nav has-shadow primary sticky-nav" itemscope itemtype="http://schema.org/SiteNavigationElement">
    <div class="nav-left">
        <a class="nav-item is-brand" href="/">
            <img src="{{ elixir('img/icon.png')  }}" alt="stefk.me logo" title="Home page">
        </a>
    </div>

    <div class="nav-center">
        <a class="nav-item" href="https://github.com/stef-k" target="_blank" title="my profile on Github">
          <span class="icon">
            <i class="fa fa-github"></i>
          </span>
        </a>

        <a class="nav-item" href="https://www.facebook.com/stef.kariotidis" target="_blank" title="find me on Facebook">
          <span class="icon">
            <i class="fa fa-facebook"></i>
          </span>
        </a>

        <a class="nav-item" href="https://gr.linkedin.com/in/stefkariotidis" target="_blank"
           title="my Linkedin profile">
          <span class="icon">
            <i class="fa fa-linkedin"></i>
          </span>
        </a>

        <a class="nav-item" href="http://stackoverflow.com/story/stefk " target="_blank"
           title="my developer story on Stack Overflow">
          <span class="icon">
            <i class="fa fa-stack-overflow"></i>
          </span>
        </a>

        <a class="nav-item" href="https://twitter.com/StefKariotidis" target="_blank" title="me at Twitter">
          <span class="icon">
            <i class="fa fa-twitter"></i>
          </span>
        </a>

        <a class="nav-item" href="https://www.instagram.com/s_t.e_f/" target="_blank" title="me at Instagram">
            <span class="icon">
                    <i class="fa fa-instagram"></i>
            </span>
        </a>
    </div>

    <span class="nav-toggle">
    <span></span>
    <span></span>
    <span></span>
  </span>

    <div class="nav-right nav-menu">
        <a class="nav-item underlinenable" href="/" title="about me">
            About
        </a>
        <a class="nav-item underlinenable" href="/posts" title="my blog posts">
            Posts
        </a>
        <a class="nav-item underlinenable" href="/projects" title="my projects">
            Projects
        </a>
        <a class="nav-item underlinenable" href="/contact" title="contact me">
            Contact
        </a>
        @if(Auth::check())
            <a class="nav-item underlinenable" href="/admin" title="admin dashboard">
                Admin
            </a>
            <a href="{{ url('/logout') }}"
               class="nav-item underlinenable"
               title="logout"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif
    </div>
</nav>
