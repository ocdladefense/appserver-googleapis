<?php 





class ExampleModule extends Module {

    public function __construct() {
        parent::__construct();
    }

    public function doAction($param) {
        $param = $param ?? "Example parameter.";

        return "The route executed with URL parameter, <i>$param</i>.";
    }


    public function doActionWithTemplate($param) {

        $tpl = new Template("example");
        $tpl->addPath(__DIR__ . "/templates");

        return $tpl;
    }


    public function doQuery() {

        $api = loadapi();

        $results = $api->query("SELECT Name, Id, Start_Date__c, Banner_Location_Text__c FROM Event__c ORDER BY Start_Date__c DESC");

        $records = $results->getRecords();

        return $records;
    }

}