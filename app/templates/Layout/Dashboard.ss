<div class="row">
    <div class="col-lg-12" style="margin-top: 50px;">
        <div class="row">
            <% include Nav %>
            <div class="col-md-9">
                <div class="card bd">
                    <div class="card-body">
                        <h4>$Title</h4>
                        <hr style="border: 1px solid black;">
                        <% if $isUserAdmin || $isUserECOfficer %>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="/dashboard/verification-code">
                                    <div class="card shadow-lg p-3 mb-5 bg-body rounded pos">
                                        <div class="card-body text-center">
                                            <h5>Generated Codes</h5>
                                            <h6>$CodeCount</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/dashboard/verification-code">
                                    <div class="card shadow-lg p-3 mb-5 bg-body rounded pos">
                                        <div class="card-body text-center">
                                            <h5>Verified Codes</h5>
                                            <h6>$VerifiedCodeCount</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/dashboard/verification-code">
                                    <div class="card shadow-lg p-3 mb-5 bg-body rounded pos">
                                        <div class="card-body text-center">
                                            <h5>Unverified Codes</h5>
                                            <h6>$UnVerifiedCodeCount</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Officer Name</th>
                                    <th scope="col">Generated Codes</th>
                                    <th scope="col">Verified Codes</th>
                                    <th scope="col">Unverified Codes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <% loop $PollingOfficers %>
                                    <tr class="table-default">
                                        <th scope="row">$Pos</th>
                                        <td>$Name</td>
                                        <td>$VerificationCodes</td>
                                        <td>$VerifiedCodes</td>
                                        <td>$UnverifiedCodes</td>
                                    </tr>
                                <% end_loop %>
                            </tbody>
                        </table>
                        <% end_if %>
                        <% if $isUserPollingOfficer %>
                        <div class="row">
                            <div class="col-md-4">
                                <a href="/dashboard/verification-code">
                                    <div class="card shadow-lg p-3 mb-5 bg-body rounded pos">
                                        <div class="card-body text-center">
                                            <h5>Generated Codes</h5>
                                            <h6>$PollingOfficerCodeCount</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/dashboard/verification-code">
                                    <div class="card shadow-lg p-3 mb-5 bg-body rounded pos">
                                        <div class="card-body text-center">
                                            <h5>Verified Codes</h5>
                                            <h6>$PollingOfficerVerifiedCodeCount</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="/dashboard/verification-code">
                                    <div class="card shadow-lg p-3 mb-5 bg-body rounded pos">
                                        <div class="card-body text-center">
                                            <h5>Unverified Codes</h5>
                                            <h6>$PollingOfficerUnVerifiedCodeCount</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <% end_if %>
                    </div>
                    <% include Footer %>
                </div>
            </div>
        </div>
    </div>
</div>
