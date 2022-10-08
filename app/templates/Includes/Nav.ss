<div class="col-md-3">
    <div class="card bd" style="width: 18rem;">
      <% if $isUserAdmin || $isUserECOfficer %>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="/dashboard"><i class="fa-solid fa-house-user"></i> Dashboard</a></li>
          <li class="list-group-item"><a href="/dashboard/position"><i class="fa-solid fa-circle-plus"></i> Positions</a></li>
          <li class="list-group-item"><a href="/dashboard/candidate"><i class="fa-solid fa-people-line"></i> Candidates</a></li>
          <li class="list-group-item"><a href="/dashboard/vote"><i class="fa-solid fa-person-booth"></i> Votes</a></li>
          <li class="list-group-item"><a href="/dashboard/polling-result"><i class="fa-solid fa-square-poll-vertical"></i> Polls Results</a></li>
          <li class="list-group-item"><a href="/dashboard/polling-officer"><i class="fa-solid fa-users"></i> Polling Officers</a></li>
          <li class="list-group-item"><a href="/dashboard/verification-code"><i class="fa-brands fa-codepen"></i> Verification Codes</a></li>
          <li class="list-group-item"><a href="/auth/logout"><i class="fa-solid fa-user-lock"></i> Logout</a></li>
        </ul>
      <% end_if %>
      <% if $isUserPollingOfficer %>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="/dashboard"><i class="fa-solid fa-house-user"></i> Dashboard</a></li>
          <li class="list-group-item"><a href="/dashboard/verification-code"><i class="fa-brands fa-codepen"></i> Verification Codes</a></li>
          <li class="list-group-item"><a href="/auth/logout"><i class="fa-solid fa-user-lock"></i> Logout</a></li>
        </ul>
      <% end_if %>
    </div>
</div>
