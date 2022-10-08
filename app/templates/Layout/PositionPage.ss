<div class="row justify-content-md-center" style="margin-top: 50px;">
    <div class="col-md-10">
        <div class="card text-center bd">
            <div class="card-header">
                <h3>2022 SRC Election For Accra Technical University.</h3>
            </div>
            <div class="card-body">
              <h4 class="card-title">$Title</h4>
              <p>$SubTitle</p>
                <div class="row">
                    <% loop $Positions %>
                        <div class="col-md-4">
                            <a href="/position/candidates/{$EncodedID}">
                                <div class="card shadow-lg p-3 mb-5 bg-body rounded pos">
                                    <div class="card-body">
                                        <h5>$Title</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <% end_loop %>
                </div>
                <a href="/position/finished-voting" onclick="return confirm('Are you sure you are done voting and want to leave this page?')">
                    <i class="fa-solid fa-lock"></i> Finished Voting
                </a>
            </div>
            <% include Footer %>
        </div>
    </div>
</div>
