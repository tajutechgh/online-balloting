<?php

use SilverStripe\ORM\DB;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Core\Convert;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Upload;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Group;
use SilverStripe\View\ArrayData;
use SilverStripe\Security\Member;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\Security\Security;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\ORM\FieldType\DBField;

class DashboardController extends PageController
{
    private static $allowed_actions = [
        'position',
        'add_position',
        'edit_position',
        'submit_position',
        'delete_position',
        'candidate',
        'add_candidate',
        'edit_candidate',
        'submit_candidate',
        'delete_candidate',
        'verification_code',
        'generate_code',
        'vote',
        'view_vote',
        'polling_officer',
        'add_polling_officer',
        'PollingOfficerForm',
        'edit_polling_officer',
        'delete_polling_officer',
        'polling_result',
    ];

    public function init()
    {
        parent::init();

        Requirements::customScript(<<<JS

            $(document).ready( function () {
                $('#myTable').DataTable({

                "scrollX": true,

                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'pdf', 'print'
                ]

                });
            } );

            // chart
            $(document).ready(function () {
                $('.skillbar').skillbar({
                    speed: 1000,
                });
            });

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-36251023-1']);
            _gaq.push(['_setDomainName', 'jqueryscript.net']);
            _gaq.push(['_trackPageview']);

            (function () {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
            '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
            })();

        JS);

        if (!Security::getCurrentUser()) {
            return $this->redirect('/auth');
        }

    }

    public function Link($action = null)
    {
        return  "/dashboard/$action";
    }

    public function index(HTTPRequest $request)
    {
        $userID = Security::getCurrentUser()->ID;

        $codeCount = VerificationCode::get()->Count();

        $verifiedCodeCount = VerificationCode::get()->filter(['Verified' => 1])->Count();

        $unVerifiedCodeCount = VerificationCode::get()->filter(['Verified' => 0])->Count();

        $pollingOfficerCodeCount = VerificationCode::get()->filter(['PollingOfficerID' => $userID])->Count();

        $pollingOfficerVerifiedCodeCount = VerificationCode::get()->filter(['PollingOfficerID' => $userID, 'Verified' => 1])->Count();

        $pollingOfficerUnVerifiedCodeCount = VerificationCode::get()->filter(['PollingOfficerID' => $userID, 'Verified' => 0])->Count();

        $pollingOfficers = Member::get()->filter(["Deleted" => 0]);

        $output = ArrayList::create();

        foreach($pollingOfficers as $pollingOfficer){

            $verificationCodes = VerificationCode::get()->filter(['PollingOfficerID' => $pollingOfficer->ID]);

            $verifiedCodes = VerificationCode::get()->filter(['PollingOfficerID' => $pollingOfficer->ID, 'Verified' => 1]);

            $unverifiedCodes = VerificationCode::get()->filter(['PollingOfficerID' => $pollingOfficer->ID, 'Verified' => 0]);

            $output->push(ArrayData::create([
                "Photo" => $pollingOfficer->Photo,
                "Name" => $pollingOfficer->Prefix." "." ".$pollingOfficer->Surname." "." ".$pollingOfficer->FirstName,
                "VerificationCodes" => $verificationCodes->Count(),
                "VerifiedCodes" => $verifiedCodes->Count(),
                "UnverifiedCodes" => $unverifiedCodes->Count(),
                "UnverifiedCodes" => $unverifiedCodes->Count(),
                "UnverifiedCodes" => $unverifiedCodes->Count(),
                "UnverifiedCodes" => $unverifiedCodes->Count(),
            ]));
        }

        return $this->Customise([
        'Title' => 'Dashboard',
        'PollingOfficerCodeCount' => $pollingOfficerCodeCount,
        'PollingOfficerVerifiedCodeCount' => $pollingOfficerVerifiedCodeCount,
        'PollingOfficerUnVerifiedCodeCount' => $pollingOfficerUnVerifiedCodeCount,
        'CodeCount' => $codeCount,
        'VerifiedCodeCount' => $verifiedCodeCount,
        'UnVerifiedCodeCount' => $unVerifiedCodeCount,
        'UnVerifiedCodeCount' => $unVerifiedCodeCount,
        'UnVerifiedCodeCount' => $unVerifiedCodeCount,
        'PollingOfficers' => $output,
        ])->renderWith(["Dashboard", "Page"]);
    }

    public function position(HTTPRequest $request)
    {
        $positions = Position::get()->filter(['Deleted' => 0]);

        return $this->Customise([
        'Title' => 'Positions',
        'Positions' => $positions,
        ]);
    }

    public function add_position(HTTPRequest $request)
    {
        return $this->Customise([
        'Title' => 'Add New Position',
        ]);
    }

    public function edit_position(HTTPRequest $request)
    {
        $id = (int) Crypto::decode($request->param('ID'));

        $position = Position::get()->filter(['ID' => $id])->first();

        return $this->Customise([
        'Title' => 'Edit Position',
        'Position' => $position,
        ]);
    }

    public function submit_position(HTTPRequest $request)
    {
        if ($request->isPost()) {

        $id = $request->postVar('ID');
        $title = $request->postVar('Title');
        $submit = $request->postVar('Submit');

        $position = Position::get()->filter(['ID' => $id])->first();

        if ($position) {

            $updatePosition = Position::get()->byID($id);

            $updatePosition->Title = $title;

            $updatePosition->write();
        }else {

            $newPosition = new Position;

            $newPosition->Title = $title;

            $newPosition->write();
        }

        if ($submit == "SubmitAndRemainOnThePage") {

            $this->setSessionMessage("Position added successfully.", 'good');

            return $this->redirectBack();

        }elseif($submit == "SubmitAndGoBack") {

            $this->setSessionMessage("Position added successfully.", 'good');

            return $this->redirect("/dashboard/position");
        }
        }
    }

    public function delete_position(HTTPRequest $request)
    {
        $id = (int) Crypto::decode($request->param('ID'));

        $position = Position::get()->filter(['ID' => $id])->first();

        if ($position) {
        $deletePosition = Position::get()->byID($id);
        }

        $deletePosition->Deleted = 1;

        $deletePosition->Write();

        $this->setSessionMessage("Position deleted successfully.", 'good');

        return $this->redirectBack();
    }

    public function candidate(HTTPRequest $request)
    {
        $candidates = Candidate::get()->filter(['Deleted' => 0]);

        return $this->Customise([
        'Title' => 'Candidates',
        'Candidates' => $candidates,
        ]);
    }

    public function add_candidate(HTTPRequest $request)
    {
        $positions = Position::get()->filter(['Deleted' => 0]);

        return $this->Customise([
        'Title' => 'Add New Candidate',
        'Positions' => $positions,
        ]);
    }

    public function edit_candidate(HTTPRequest $request)
    {
        $id = (int) Crypto::decode($request->param('ID'));

        $candidate = Candidate::get()->filter(['ID' => $id])->first();

        $positions = Position::get()->filter(['Deleted' => 0]);

        return $this->Customise([
        'Title' => 'Edit Candidate',
        'Candidate' => $candidate,
        'Positions' => $positions,
        ]);
    }

    public function submit_candidate(HTTPRequest $request)
    {
        if ($request->isPost()) {

        $id = $request->postVar('ID');
        $title = $request->postVar('Title');
        $name = $request->postVar('Name');
        $positionID = $request->postVar('PositionID');
        $file = $request->postVar('Photo');
        $submit = $request->postVar('Submit');

        if (!empty($file['name'])) {
            $folder = "candidate-images";
            Folder::find_or_make($folder);
            $imgFile = Image::create();
            $upload = Upload::create();
            $upload->loadIntoFile($file, $imgFile, $folder);
            $photoID = $upload->getFile()->ID;
        }else{
            $photoID = $request->postVar('PhotoID');
        }

        $candidate = Candidate::get()->filter(['ID' => $id])->first();

        if ($candidate) {

            $updateCandidate = Candidate::get()->byID($id);

            $updateCandidate->Title = $title;
            $updateCandidate->Name = $name;
            $updateCandidate->PositionID= $positionID;
            $updateCandidate->PhotoID = $photoID;

            $updateCandidate->write();
        }else {

            $newCandidate = new Candidate;

            $newCandidate->Title = $title;
            $newCandidate->Name = $name;
            $newCandidate->PositionID= $positionID;
            $newCandidate->PhotoID = $photoID;

            $newCandidate->write();
        }

        if ($submit == "SubmitAndRemainOnThePage") {

            $this->setSessionMessage("Candidate added successfully.", 'good');

            return $this->redirectBack();

        }elseif($submit == "SubmitAndGoBack") {

            $this->setSessionMessage("Candidate added successfully.", 'good');

            return $this->redirect("/dashboard/candidate");
        }
        }
    }

    public function delete_candidate(HTTPRequest $request)
    {
        $id = (int) Crypto::decode($request->param('ID'));

        $candidate = Candidate::get()->filter(['ID' => $id])->first();

        if ($candidate) {
        $deleteCandidate = Candidate::get()->byID($id);
        }

        $deleteCandidate->Deleted = 1;

        $deleteCandidate->Write();

        $this->setSessionMessage("Candidate deleted successfully.", 'good');

        return $this->redirectBack();
    }

    public function verification_code()
    {
        $userID = Security::getCurrentUser()->ID;

        $codes = VerificationCode::get()->sort("ID", "DESC");

        $pollingOfficerCodes = VerificationCode::get()->filter(['PollingOfficerID' => $userID])->sort("ID", "DESC");

        return $this->Customise([
        'Title' => 'Verification Codes',
        'Codes' => $codes,
        'PollingOfficerCodes' => $pollingOfficerCodes,
        ]);
    }

    public function generate_code()
    {
        $code = uniqid();
        $userID = Security::getCurrentUser()->ID;

        $verificationCode = new VerificationCode;

        $verificationCode->Code = $code;
        $verificationCode->PollingOfficerID = $userID;

        $verificationCode->write();

        $this->setSessionMessage("Code generated successfully.", 'good');

        return $this->redirectBack();
    }

    public function vote(HTTPRequest $request)
    {
        $positions = Position::get()->filter(['Deleted' => 0]);

        $output = ArrayList::create();

        foreach($positions as $position){

        $votes = Vote::get()->filter(['PositionID' => $position->ID]);

        $output->push(ArrayData::create([
            'EncodedID' => Crypto::encode($position->ID),
            'Title' => $position->Title,
            'CountVote' => $votes->Count(),
        ]));
        }

        return $this->Customise([
        'Title' => 'Votes',
        'Positions' => $output,
        ]);
    }

    public function view_vote(HTTPRequest $request)
    {
        $id = (int) Crypto::decode($request->param('ID'));

        $position = Position::get()->byID($id);

        $candidates = Candidate::get()->filter(['PositionID' => $id]);

        $output = ArrayList::create();

        foreach($candidates as $candidate){

        $votes = Vote::get()->filter(['CandidateID' => $candidate->ID]);

        $output->push(ArrayData::create([
            "Photo" => $candidate->Photo,
            "Name" => $candidate->Title." "." ".$candidate->Name,
            "CountVote" => $votes->Count(),
        ]));
        }

        return $this->Customise([
        'Title' => 'Votes For '.$position->Title.' Position',
        'Candidates' => $output,
        ]);
    }

    public function polling_officer()
    {
        $pollingOfficers = Member::get()->filter(['MemberType' => 'Polling Officer', 'Deleted' => 0])->sort("ID", "DESC");

        return $this->Customise([
        'Title' => 'Polling Officers',
        'PollingOfficers' => $pollingOfficers,
        ]);
    }

    public function add_polling_officer()
    {
        return $this->Customise([
        'Title' => 'Add Polling Officer',
        ]);
    }

    public function PollingOfficerForm()
    {
        $ID = $this->getRequest()->param('ID');

        if ($ID) {
        if ($this->getRequest()->isPOST()) {
            $ID = $this->getRequest()->postVar('ID');
        } else {
            $ID = Crypto::decode($this->getRequest()->param('ID'));
        }
        $pollingOfficer = Member::get()->byID((int) $ID);
        } else {
        $pollingOfficer = null;
        }

        return new PollingOfficerForm($this, 'PollingOfficerForm', $pollingOfficer);
    }

    public function edit_polling_officer()
    {
        return $this->Customise([
        'Title' => 'Edit Polling Officer',
        ]);
    }

    public function delete_polling_officer(HTTPRequest $request)
    {
        $id = (int) Crypto::decode($request->param('ID'));

        $pollingOfficer = Member::get()->filter(['ID' => $id])->first();

        if ($pollingOfficer) {
        $deletePollingOfficer = Member::get()->byID($id);
        }

        $deletePollingOfficer->Deleted = 1;

        $deletePollingOfficer->Write();

        $this->setSessionMessage("Polling officer deleted successfully.", 'good');

        return $this->redirectBack();
    }

    public function polling_result()
    {
        return $this->Customise([
        'Title' => 'Polling Results',
        ]);
    }

    public function chart()
    {

        $positions = Position::get()->filter(['Deleted' => 0]);

        $output = "";

        foreach ($positions as $position) {

            $output .= '<div class="card-body">

                            <h5>Percentage Results For '.$position->Title." Candidates".'</h5>

                            <div id="skill">';

                                foreach($position->Candidates() as $candidate){

                                    $votes = Vote::get()->filter(['CandidateID' => $candidate->ID]);

                                    $totalVotes = Vote::get();

                                    $percentage = round($votes->Count()/$totalVotes->Count() * 100, 0);

                                    $output .= '<div class="skillbar html">
                                                    <div class="filled" data-width="'.$percentage.'%"></div>';
                                                    $output .= '<span class="title">'.$candidate->Title." "." ".$candidate->Name.'</span>';
                                                    $output .= '<span class="percent">'.$percentage."%".'</span>';
                                    $output .=  '</div>';
                                }
            $output .= '    </div>
                        </div>';
        }

        return $output;
    }

}
