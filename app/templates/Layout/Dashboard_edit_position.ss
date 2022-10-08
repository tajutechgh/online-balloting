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
                        <form action="/dashboard/submit-position" method="post">
                            <input type="hidden" name="ID" value="$Position.ID" required>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="title">Position Title:</label>
                                    <input type="text" class="form-control" name="Title" value="$Position.Title" required>
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
