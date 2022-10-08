<div class="row">
    <div class="col-lg-12" style="margin-top: 50px;">
        <div class="row">
            <% include Nav %>
            <div class="col-md-9">
                <div class="card bd">
                    <div class="card-body">
                        <h4>$Title</h4>
                        <% include Notification %>
                        <hr style="border: 1px solid black;">
                        <% if $isUserAdmin || $isUserECOfficer %>
                            <a href="/dashboard/generate-code" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> Generate New Code</a>
                            <table id="myTable" class="table table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <th>#</th>
                                    <th>Verification Code</th>
                                    <th>Time Created</th>
                                    <th>Polling Officer</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <% loop $Codes %>
                                    <tr>
                                        <td>$Pos</td>
                                        <td>$Code</td>
                                        <td>$Created</td>
                                        <td>$PollingOfficer.Prefix $PollingOfficer.Surname $PollingOfficer.FirstName</td>
                                        <td>
                                            <% if $Verified == 1 %>
                                                <button type="button" class="btn btn-success btn-sm">Verified</button>
                                            <% else_if $Verified == 0 %>
                                                <button type="button" class="btn btn-danger btn-sm">Not Verified</button>
                                            <% end_if %>
                                        </td>
                                    </tr>
                                    <% end_loop %>
                                </tbody>
                            </table>
                        <% end_if %>
                        <% if $isUserPollingOfficer %>
                            <a href="/dashboard/generate-code" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> Generate New Code</a>
                            <table id="myTable" class="table table-hover" cellspacing="0" width="100%">
                                <thead>
                                    <th>#</th>
                                    <th>Verification Code</th>
                                    <th>Time Created</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <% loop $PollingOfficerCodes %>
                                    <tr>
                                        <td>$Pos</td>
                                        <td>$Code</td>
                                        <td>$Created</td>
                                        <td>
                                            <% if $Verified == 1 %>
                                                <button type="button" class="btn btn-success btn-sm">Verified</button>
                                            <% else_if $Verified == 0 %>
                                                <button type="button" class="btn btn-danger btn-sm">Not Verified</button>
                                            <% end_if %>
                                        </td>
                                    </tr>
                                    <% end_loop %>
                                </tbody>
                            </table>
                        <% end_if %>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
