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
                        <form action="/dashboard/submit-candidate" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="ID" value="$Candidate.ID" required>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="title">Select Title:</label>
                                    <select name="Title" class="form-control" required style="margin-bottom:20px;">
                                        <option value="$Candidate.Title">$Candidate.Title</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Miss">Miss</option>
                                    </select>
                                    <label for="name">Full Name:</label>
                                    <input type="text" class="form-control" name="Name" required style="margin-bottom: 20px;" value="$Candidate.Name">
                                    <label for="position">Select Position:</label>
                                    <select name="PositionID" class="form-control" required style="margin-bottom:20px;">
                                        <option value="$Candidate.Position.ID">$Candidate.Position.Title</option>
                                        <% loop Positions %>
                                            <option value="$ID">$Title</option>
                                        <% end_loop %>
                                    </select>
                                    <input type="hidden" name="PhotoID" value="$Candidate.PhotoID">
                                    <input type="file" class="form-control" name="Photo" style="margin-bottom: 20px;">
                                </div>
                                <div class="col-md-4">
                                    <br>
                                    <button type="submit" class="form-control btn btn-success" name="Submit" value="SubmitAndRemainOnThePage">Submit And Remain On This Page</button>
                                    <br><br>
                                    <button type="submit" class="form-control btn btn-success" name="Submit" value="SubmitAndGoBack">Submit And Go Back</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <% include Footer %>
                </div>
            </div>
        </div>
    </div>
</div>
