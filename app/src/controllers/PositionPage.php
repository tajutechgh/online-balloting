<?php 

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\Control\HTTPRequest;

class PositionPageController extends PageController 
{
    private static $allowed_actions = [
        'candidates',
        'vote',
        'finished_voting',
    ]; 

    public function init()
    {
        parent::init();

        Requirements::customScript(<<<JS

            (function($) {
                $(document).ready(function() {

                    $(document).on('change', '#voted', function () {

                        var el = $(this).closest('tr');

                        var cid = el.find("#cid").val();
                        var pid = el.find("#pid").val();
                        var voted = el.find("#voted").val();

                        location.reload(true);

                        $.ajax({
                            method: 'POST',
                            url: '/position/vote',
                            cache: false,
                            data: {
                                cid: cid,
                                pid: pid,
                                voted: voted,
                            },
                            success: function(response) {
                                console.log(response);
                            }
                        });

                    });
                });
            }(jQuery));
        JS
        );

    }

    public function index(HTTPRequest $request)
    {
        $session = $request->getSession();

        $vCodes = $session->get('verification.code');

        $vCodes_items = unserialize($vCodes);

        foreach($vCodes_items as $value){

            $code = $value->Code;
            
        }

        $verified = VerificationCode::get()->filter(['Code' => $code])->first();

        if ($verified->Verified != 1) {

            return $this->redirect('/home');

        }else{
            $positions = Position::get()->sort('Title', 'ASC');

            return $this->customise([
                'Title' => 'SRC Positions',
                'SubTitle' => 'Kindly click on the positions available to vote for your choice.',
                'Positions' => $positions,
            ]);
        }
    }

    public function candidates(HTTPRequest $request)
    {
        $id = (int) Crypto::decode($request->param('ID'));

        $session = $request->getSession();

        $vCodes = $session->get('verification.code');

        $vCodes_items = unserialize($vCodes);

        foreach($vCodes_items as $value){

            $vCodeID = $value->ID;
            
        }

        $position = Position::get()->byID($id);

        $output = ArrayList::create();

        foreach ($position->Candidates() as $candidate) {

            $output->push(ArrayData::create([
                "ID" => $candidate->ID,
                "PositionID" => $candidate->PositionID,
                "Photo" => $candidate->Photo,
                "Name" => $candidate->Title." "." ".$candidate->Name,
                "Voted" => $candidate->Votes()->filter(['VerificationCodeID' => $vCodeID])->Count(),
            ]));
        }

        $voteExist = Vote::get()->filter(['PositionID' => $id,'VerificationCodeID' => $vCodeID])->first();

        return $this->customise([
            'Title' => '2022 SRC Election For Accra Technical University.',
            'Note' => 'You can only vote once!',
            'SubTitle' => 'Candidates For The SRC '.$position->Title.' Position.',
            'Candidates' => $output,
            'VoteExist' => $voteExist,
        ]);
    }

    public function vote(HTTPRequest $request)
    {
        $session = $request->getSession();

        $vCodes = $session->get('verification.code');

        $vCodes_items = unserialize($vCodes);

        foreach($vCodes_items as $value){

            $codeID = $value->ID;
            
        }

        $vote = $request->postVar('voted');

        if(isset($vote)){

            $cid = $request->postVar('cid');
            $pid = $request->postVar('pid');
            $vote = $vote;

            $voted = Vote::get()->filter(['VerificationCodeID' => $codeID, 'PositionID' => $pid])->first();

            if ($voted) {
                
                $voted->Status = $vote;
                $voted->CandidateID = $cid;
                $voted->PositionID = $pid;
                $voted->VerificationCodeID = $codeID;

                $voted->write();

            }else{

                $newVote = new Vote;

                $newVote->Status = $vote;
                $newVote->CandidateID = $cid;
                $newVote->PositionID = $pid;
                $newVote->VerificationCodeID = $codeID;

                $newVote->write();
            }
        }

        return $this->redirectBack();
    }

    public function finished_voting(HTTPRequest $request)
    {
        $session = $request->getSession();

        $session->clear('verification.code');

        return $this->redirect('/home');
    }
}