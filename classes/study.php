<?php

class Study {

    public $studyId;
    public $testAnswers;
    public $testScore;
    public $ic1;
    public $ic2;
    public $decision;
    public $confidence;
    public $reasons;

    function getStudyId() {
        return $this->studyId;
    }

    function setStudyId($studyId) {
        $this->studyId = $studyId;
    }

    function getTestAnswers() {
        return $this->testAnswers;
    }

    function setTestAnswers($testAnswers) {
        $this->testAnswers = $testAnswers;
    }

        function getTestScore() {
        return $this->testScore;
    }

    function getIc1() {
        return $this->ic1;
    }

    function getIc2() {
        return $this->ic2;
    }

    function getDecision() {
        return $this->decision;
    }

    function getConfidence() {
        return $this->confidence;
    }

    function setTestScore($testScore) {
        $this->testScore = $testScore;
    }

    function setIc1($ic1) {
        $this->ic1 = $ic1;
    }

    function setIc2($ic2) {
        $this->ic2 = $ic2;
    }

    function setDecision($decision) {
        $this->decision = $decision;
    }

    function setConfidence($confidence) {
        $this->confidence = $confidence;
    }
    
    function getReasons() {
        return $this->reasons;
    }

    function setReasons($reasons) {
        $this->reasons = $reasons;
    }

}

?>