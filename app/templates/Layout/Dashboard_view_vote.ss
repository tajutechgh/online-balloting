<div class="row">
    <div class="col-lg-12" style="margin-top: 50px;">
        <div class="row">
            <% include Nav %>
            <div class="col-md-9">
                <div class="card bd">
                    <div class="card-body">
                        <h4>$Title</h4>
                        <hr style="border: 1px solid black;">
                        <table id="myTable" class="table table-hover" cellspacing="0" width="100%">
                            <thead>
                                <th>#</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Total Votes</th>
                            </thead>
                            <tbody>
                                <% loop $Candidates.Sort(CountVote, DESC) %>
                                <tr>
                                    <td>$Pos</td>
                                    <td><img src="$Photo.Fill(50,50).URL" alt="candidate-image"></td>
                                    <td>$Name</td>
                                    <td>$CountVote</td>
                                </tr>
                                <% end_loop %>
                            </tbody>
                        </table>
                        <div class="text-center">
                            <a href="/dashboard/vote"><i class="fa-solid fa-arrow-left"></i> Go Back</a>
                        </div>
                    </div>
                    <% include Footer %>
                </div>
            </div>
        </div>
    </div>
</div>
