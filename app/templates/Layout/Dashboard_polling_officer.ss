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
                        <a href="/dashboard/add-polling-officer" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> Add New Polling Officer</a>
                        <table id="myTable" class="table table-hover" cellspacing="0" width="100%">
                            <thead>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                                <th width="15%">Action</th>
                            </thead>
                            <tbody>
                                <% loop $PollingOfficers %>
                                <tr>
                                    <td>$Pos</td>
                                    <td><img src="$Photo.Fill(50,50).URL" alt="polling-officer-image"></td>
                                    <td>$Prefix $Surname $FirstName</td>
                                    <td>$PhoneNumber</td>
                                    <td>$Email</td>
                                    <td>
                                        <a href="/dashboard/edit-polling-officer/{$EncodedID}" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="/dashboard/delete-polling-officer/{$EncodedID}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?')"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <% end_loop %>
                            </tbody>
                        </table>
                    </div>
                    <% include Footer %>
                </div>
            </div>
        </div>
    </div>
</div>
