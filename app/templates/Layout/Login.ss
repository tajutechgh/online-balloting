<div class="row justify-content-md-center" style="margin-top: 150px;">
    <div class="col-md-6 text-center vc">
        <img src="$resourceURL('app/assets/img/vote.png')" alt="ballot-image" class="sp">
        <h3 class="sp">E-BALLOTING</h3>
        <% include Notification %>
        <div class="card shadow p-3 mb-5 bg-body rounded sp" style="height: 270px;">
            <div class="card-body">
                <div class="row justify-content-md-center">
                    <div class="col-md-8">
                        <h5 style="margin-bottom: 20px">$Title</h5>
                        <form action="/auth/login" method="post">
                            <input type="email" name="Email" class="form-control" placeholder="Enter your email address" required>
                            <input type="password" name="Password" class="form-control" placeholder="Enter your password" required style="margin-top: 20px;">
                            <button type="submit" class="btn btn-success" style="margin-top: 20px; width: 100%;">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
