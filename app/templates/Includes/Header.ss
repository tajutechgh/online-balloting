<%-- <div class="card bd">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="text-center" style="margin-top: 10px;">
                            <i class="fa-solid fa-calendar"></i> $Now.Date
                        </h4>
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-center" style="margin-top: 10px;">
                            <i class="fa-solid fa-clock"></i> $Now.Time
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="text-center" style="margin-top: 10px;">
                            <i class="fa-solid fa-check-to-slot"></i> E-BALLOTING
                        </h4>
                    </div>
                    <div class="col-md-6">
                        <marquee behavior="" direction="">
                            <h4 class="text-center" style="margin-top: 10px;">
                                <i class="fa-solid fa-user-large"></i> Welcome $CurrentUser.Prefix $CurrentUser.Surname $CurrentUser.FirstName
                            </h4>
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br> --%>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
          <a class="navbar-brand" href="$BaseHref">E-Balloting</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <% if $CurrentUser %>
            <div class="collapse navbar-collapse" id="navbarColor01" style="flex-grow: 0;">
                <ul class="navbar-nav me-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="$BaseHref">Home</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-user"></i> $CurrentUser.Prefix $CurrentUser.Surname $CurrentUser.FirstName</a>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="/dashboard">Dashboard</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="/auth/logout">Logout</a>
                    </div>
                  </li>
                </ul>
            </div>
          <% else %>
            <div class="collapse navbar-collapse" id="navbarColor01" style="flex-grow: 0;">
                <ul class="navbar-nav me-auto">
                  <li class="nav-item">
                    <a class="nav-link" href="/auth">Login</a>
                  </li>
                </ul>
            </div>
          <% end_if %>
        </div>
    </nav>
</header>
