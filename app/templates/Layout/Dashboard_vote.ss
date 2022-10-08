<div class="row">
    <div class="col-lg-12" style="margin-top: 50px;">
        <div class="row">
            <% include Nav %>
            <div class="col-md-9">
                <div class="card bd">
                    <div class="card-body">
                        <h4>$Title</h4>
                        <hr style="border: 1px solid black;">
                        <div class="row">
                            <% loop $Positions %>
                                <div class="col-md-4">
                                    <a href="/dashboard/view-vote/{$EncodedID}">
                                        <div class="card shadow-lg p-3 mb-5 bg-body rounded pos">
                                            <div class="card-body text-center">
                                                <h5>$Title</h5>
                                                <h6>Total Votes: $CountVote</h6>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <% end_loop %>
                        </div>
                    </div>
                    <% include Footer %>
                </div>
            </div>
        </div>
    </div>
</div>
