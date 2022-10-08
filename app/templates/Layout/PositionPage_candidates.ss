<div class="row justify-content-md-center" style="margin-top: 50px;">
    <div class="col-md-10">
        <div class="card text-center bd">
            <div class="card-header">
                <h3>$Title</h3>
            </div>
            <div class="card-body">
                <h4 class="card-title">$SubTitle</h4>
                <% if not $VoteExist %>
                    <h5 class="card-title"><strong>IMPORTANT NOTICE:</strong> $Note</h5>
                    <p>Kindly vote for the candidate of your choice.</p>
                    <table class="table table-hover">
                        <thead>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Vote</th>
                        </thead>
                        <tbody>
                            <% loop $Candidates %>
                                <tr>
                                    <td>$Pos</td>
                                    <td><img src="$Photo.Fill(50,50).URL" alt="candidate-image"></td>
                                    <td>$Name</td>
                                    <td>
                                        <input type="hidden" id="cid" value="$ID">
                                        <input type="hidden" id="pid" value="$PositionID">
                                        <input class="form-check-input" type="checkbox" id="voted" value="1"
                                            <% if $Voted == 1 %>
                                                checked
                                            <% end_if %>
                                        >
                                    </td>
                                </tr>
                            <% end_loop %>
                        </tbody>
                    </table>
                <% else %>
                    <h5>You voted for the candidate below!</h5>
                    <% with $VoteExist %>
                    <div class="row justify-content-md-center">
                        <div class="col-md-4" style="margin-left: 37px;">
                            <div class="card shadow p-3 mb-5 bg-body rounded" style="width: 18rem;">
                                <img src="$Candidate.Photo.Fill(250,270).URL" class="card-img-top" alt="candidate-image">
                                <div class="card-body">
                                  <h5 class="card-title">$Candidate.Title $Candidate.Name</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <% end_with %>
                <% end_if %>
                <a href="/position"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
            </div>
        </div>
    </div>
</div>
