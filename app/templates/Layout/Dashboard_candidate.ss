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
                        <a href="/dashboard/add-candidate" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i> Add New Candidate</a>
                        <table id="myTable" class="table table-hover" cellspacing="0" width="100%">
                            <thead>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th width="15%">Action</th>
                            </thead>
                            <tbody>
                                <% loop $Candidates %>
                                <tr>
                                    <td>$Pos</td>
                                    <td><img src="$Photo.Fill(50,50).URL" alt="candidate-image"></td>
                                    <td>$Title $Name</td>
                                    <td>$Position.Title</td>
                                    <td>
                                        <a href="/dashboard/edit-candidate/{$EncodedID}" class="btn btn-success"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="/dashboard/delete-candidate/{$EncodedID}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this?')"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                                <% end_loop %>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
