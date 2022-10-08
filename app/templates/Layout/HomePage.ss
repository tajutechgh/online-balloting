<div class="row justify-content-md-center" style="margin-top: 150px;">
    <div class="col-md-6 text-center vc">
        <img src="$resourceURL('app/assets/img/vote.png')" alt="ballot-image" class="sp">
        <h3 class="sp">E-BALLOTING</h3>
        <% include Notification %>
        <div class="card shadow p-3 mb-5 bg-body rounded sp" style="height: 250px;">
            <div class="card-body" style="margin-top: 30px;">
                <div class="row justify-content-md-center">
                    <div class="col-md-8">
                        <form action="/home/verify-code" method="post">
                            <h5 class="card-title">Enter Your Verification Code!</h5>
                            <input type="text" name="VerificationCode" class="form-control" placeholder="*************" required>
                            <button type="submit" class="btn btn-success" style="margin-top: 20px; width: 100%;">Proceed To Vote</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
