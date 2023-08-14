<?php 





class GoogleApiModule extends Module {

    public function __construct() {
        parent::__construct();
    }

    public function getEvents($calendarId) {
        
        putenv('GOOGLE_APPLICATION_CREDENTIALS=/var/www/appdev/simple-server/config/biere-library-24c45bfb875d.json');

        $calendar = $calendarId . "@group.calendar.google.com";

        $client = new Google\Client();

        // https://developers.google.com/resources/api-libraries/documentation/calendar/v3/php/latest/class-Google_Service_Calendar_Event.html
        // https://developers.google.com/calendar/api/v3/reference/events/list
        // https://devsware.wordpress.com/2015/03/28/google-calendar-api-server-to-server-web-application/
        // https://github.com/googleapis/google-api-php-client
        // https://github.com/googleapis/google-api-php-client/blob/main/examples/service-account.php


        // https://www.cssscript.com/calendar-icons/
        /************************************************
         ATTENTION: Fill in these values, or make sure you
        have set the GOOGLE_APPLICATION_CREDENTIALS
        environment variable. You can get these credentials
        by creating a new Service Account in the
        API console. Be sure to store the key file
        somewhere you can get to it - though in real
        operations you'd want to make sure it wasn't
        accessible from the webserver!
        Make sure the Books API is enabled on this
        account as well, or the call will fail.
        ************************************************/

        if (false && $credentials_file = checkServiceAccountCredentialsFile()) {
            // set the location manually
            $client->setAuthConfig($credentials_file);
        } elseif (getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
            // use the application default credentials
            $client->useApplicationDefaultCredentials();
        } else {
            echo missingServiceAccountDetailsWarning();
            return;
        }

        $client->setApplicationName("Lib3");
        // $client->addScope(Google\Service\Calendar::CALENDAR_EVENTS);
        $service = new Google\Service\Calendar($client);
        // var_dump($service);

        $client->addScope(Google\Service\Calendar::CALENDAR_READONLY);

        // if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
        // $client->setAccessToken($_SESSION['access_token']);

        // Print the next 10 events on the user's calendar.
        // $calendarId = 'primary';

        
        $optParams = array(
            'maxResults' => 10,
            'orderBy' => 'startTime',
            'singleEvents' => TRUE,
            'timeMin' => date('c'),
        );

        $service = new Google\Service\Calendar($client);
        $results = $service->events->listEvents($calendar, $optParams);


        // var_dump($results->getItems());


        return $results->getItems();
    }

}