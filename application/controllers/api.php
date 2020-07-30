<?php
/**
 * Use a class check if any of the keys parsed is not valid
 * This will help prevent the case where users parse an invalid data as part of their
 * payload to the server.
 */
class Api {

    /* Leave it open to allow the user to preset it */
    public $inner_url;
    public $outer_url;

    /* Allow the user to preset the the userId and clientId after instantiating the class */
    public $userId;
    public $brandId;
    public $clientId;

    /* method will contain the request method parsed by the user */
    public $method;

    /* the endpoint variable is only accessible in the class */
    private $endpoints;

    private $requestPayload;

    const PERMISSION_DENIED = "Sorry! You do not have the required permissions to perform this action.";

    /**
     * Preset these variables when the class is initiated
     * 
     * @param {array} $param   This will hold an array of the user brand and client ids
     */
    public function __construct(array $param) {
        /**
         * global variables
         **/
        global $session, $accessObject, $config, $usersClass, $bookingClass;

        $this->session = $session;

        $this->config = $config;
        $this->accessCheck = $accessObject;
        $this->userId = $param['userId'];
        $this->clientId = $param['clientId'];

        $this->accessCheck->userId = $param['userId'];
        $this->bookingClass = $bookingClass;

        // load the user data
        $this->userData = $usersClass->item_by_id("users", $param['userId']);
        $this->clientData = $bookingClass->clientData;

        // set the global variables
        $bookingClass->user_guid = $this->userId;
        $bookingClass->client_guid = $this->clientId;
        $bookingClass->clientId = $this->clientId;

        /**
         * The endpoint will be an associative array which where the switch will be done 
         * based on the request type that the user has sent.
         * This can be saved in a json file and requested from the server
         * 
         * Usage Example
         * 
         * Load the file and convert the content into an array 
         *  
         * $this->endpoints = json_decode(file_get_contents('assets/endpoints.json'), true)
         */
        $this->endpoints = [
            "users" => [
                "GET" => [
                    "list" => [
                        "description" => "This endpoint lists users from the database.",
                        "params" => [
                            "limit" => "This is the number to limit the results",
                            "user_id" => "This is applied when the user has parsed an ID. This will limit the result by the user id parsed."
                        ]
                    ],
                    "history" => [
                        "description" => "This endpoint returns the list of user activity logs",
                        "params" => [
                            "user_id" => "required - The user id to load the activity logs",
                            "limit" => "The number of rows to return"
                        ]
                    ],
                    "access_levels" => [
                        "description" => "This endpoint returns an arrayed list of access level parameters that are associated to that particular access level",
                        "params" => [
                            "level_id" => "The access level id parsed"
                        ]
                    ]
                ],
                "POST" => [
                    "add" => [
                        "description" => "This endpoint is used for creating a user account",
                        "params" => [
                            "fullname" => "required - The fullname of the user",
                            "access_level" => "The Access Level Permissions of this user",
                            'access_level_id' => "This is the user access level id",
                            'contact' => 'The contact number of the  Account Holder',
                            "email" => "required - The email address of the user",
                            "username" => "The username must always be unique",
                            'user_image' => 'The user image for profile picture',
                            "theme" => "This is the default background theme to use (light-theme or dark-theme)",
                            "navbar" => "This specifies whether the navigation bar must be hidden or visible"
                        ]
                    ],
                    "update" => [
                        "description" => "This endpoint updates a user profile",
                        "params" => [
                            'user_image' => 'The user image for profile picture',
                            'fullname' => 'required - Provide the lastname',
                            'email' => 'required - This is the Email Address of the Account Holder',
                            'user_guid' => 'required - The user id to update',
                            'username' => 'required - The username of the user',
                            'access_level_id' => "This is the user access level id",
                            'contact' => 'The contact number of the  Account Holder',
                            'access_level' => 'array - The access Level of the user',
                            "theme" => "This is the default background theme to use (light-theme or dark-theme)",
                            "navbar" => "This specifies whether the navigation bar must be hidden or visible"
                        ]
                    ],
                    "history" => [
                        "description" => "This endpoint returns the list of user activity logs",
                        "params" => [
                            "user_id" => "required - The user id to load the activity logs",
                            "limit" => "The number of rows to return"
                        ]
                    ],
                    "access_levels_list" => [
                        "description" => "This endpoint returns an arrayed list of access level parameters that are associated to that particular access level",
                        "params" => [
                            "level_id" => "required - The access level id parsed",
                            "user_guid" => "The user id to update the access level permissions",
                        ]
                    ],
                    "permissions" => [
                        "description" => "Load the users access permissions",
                        "params" => [
                            "user_id" => "The access level id parsed",
                            "access_level" => "The access level id to load the permissions"
                        ]
                    ],
                    "change_password" => [
                        "description" => "Use this endpoint to change a users password",
                        "params" => [
                            "user_guid" => "required - This is the unique user id to change the password.",
                            "password" => "required - Enter the password",
                            "password_2" => "required - Reenter password to confirm"
                        ]
                    ],
                    "access_levels" => [
                        "description" => "Update the user access permissions",
                        "params" => [
                            "user_id" => "required - The user id to update the access level permissions",
                            "access_level" => "required - The access level",
                            "access_permissions" => "required - Array of the access levels"
                        ]
                    ]
                ],
                "PUT" => [
                    "theme" => [
                        "description" => "Use this endpoint to update the users defualt theme",
                        "params" => [
                            "theme" => "required - This is the theme color to be set"
                        ]
                    ],
                    "update" => [
                        "description" => "Use this endpoint to update the users informatin",
                        "params" => [
                            "user_id" => "required - The unique id of the user",
                            "fullname" => "required - The fullname of the user",
                            "access_level" => "required - The Access Level Permissions of this user",
                            "gender" => "The gender",
                            "contact" => "The phone number of the user",
                            "email" => "required - The email address of the user"
                        ]
                    ]
                ]
            ],
            "halls" => [
                "GET" => [
                    "list" => [
                        "params" => [
                            "limit" => "The number of rows to return in the results",
                            "hall_guid" => "The Id of the hall to load the data"
                        ]
                    ]
                ],
                "POST" => [
                    "add" => [
                        "params" => [
                            "hall_name" => "required - The name of the hall",
                            "hall_rows" => "required - The the number of rows",
                            "hall_columns" => "required - The number of columns",
                            "description" => "Sample description / facilities of this hall"
                        ]
                    ],
                    "activate" => [
                        "params" => [
                            "hall_guid" => "required - This is the unique guid of the hall to activate."
                        ]
                    ],
                    "reset" => [
                        "params" => [
                            "hall_guid" => "required - This is the unique guid of the hall to reset."
                        ]
                    ],
                    "configure" => [
                        "params" => [
                            "available_seats" => "required - An array of the available seats. (Check documentation for the format)",
                            "blocked_seats" => "An array of the blocked seats. (Check documentation for the format)",
                            "removed_seats" => "An array of the removed seats. (Check documentation for the format)",
                            "hall_guid" => "required - The unique id of the hall."
                        ]
                    ],
                    "update" => [
                        "params" => [
                            "hall_name" => "required - The name of the hall",
                            "hall_rows" => "required - The the number of rows",
                            "hall_columns" => "required - The number of columns",
                            "description" => "Sample description / facilities of this hall",
                            "hall_guid"=> "required - The unique guid of the hall",
                        ]
                    ]
                ]
            ],
            "reservations" => [
                "GET" => [
                    "list" => [
                        "params" => [
                            "limit" => "The number of rows to return in the results",
                            "event_guid" => "The Event Id to Filter the Results"
                        ]
                    ]
                ],
                "POST" => [
                    "reserve" => [
                        "params" => [
                            "event_guid" => "required - The Event that the user is booking",
                            "hall_guid" => "required - The hall that is been booked",
                            "hall_guid_key" => "required - This is for hall key as it appears in the list of halls for the event",
                            "ticket_serial" => "The serial number for the ticket.",
                            "booking_details" => "required - The details of the user making the booking. (Please refer to the documentation at https://api.eventsplanner.com for the appropriate format)"
                        ]
                    ]
                ]
            ],
            "departments" => [
                "GET" => [
                    "list" => [
                        "params" => [
                            "limit" => "The number of rows to return in the results",
                            "department_guid" => "The Id of the Department"
                        ]
                    ]
                ],
                "POST" => [
                    "add" => [
                        "params" => [
                            "department_name" => "required - The name of the department",
                            "color" => "The color representing that department",
                            "description" => "Additional description"
                        ],
                    ],
                    "update" => [
                        "params" => [
                            "department_name" => "required - The name of the department",
                            "color" => "The color representing that department",
                            "description" => "Additional description",
                            "department_guid" => "The unique id of the department"
                        ],
                    ]
                ]
            ],
            "tickets" => [
                "GET" => [
                    "list" => [
                        "params" => [
                            "limit" => "The number of rows to return in the results",
                            "ticket_guid" => "The Id of the ticket to load the data",
                            "event_guid" => "This filters the list of tickets by the Event Guid"
                        ]
                    ],
                    "sales-list" => [
                        "params" => [
                            "limit" => "The number of rows to return in the results",
                            "serial" => "The Id of the ticket serial to load the data",
                            "date" => "This is the date for which the user wants to fetch the records"
                        ]
                    ]
                ],
                "POST" => [
                    "activate" => [
                        "params" => [
                            "ticket_guid" => "required - The id for the generated tickets to be activated"
                        ]
                    ],
                    "validate" => [
                        "params" => [
                            "ticket_guid" => "required - The id for the generated tickets to be validated.",
                            "event_guid" => "required - This is the unique id for the event."
                        ]
                    ],
                    "sell" => [
                        "params" => [
                            "ticket_guid" => "required - The id for the generated tickets to be validated.",
                            "event_guid" => "required - This is the unique id for the event.",
                            "fullname" => "required - The fullname of the person making the purchase.",
                            "contact" => "required - The contact number of the person making the purchase.",
                            "email" => "The email address of the person making the purchase.",
                        ]
                    ],
                    "generate" => [
                        "params" => [
                            "ticket_title" => "required - The title for this ticket.",
                            "quantity" => "The number of Tickets to be generated (default is 100).",
                            "initials" => "Any initials for be appended to this ticket.",
                            "length" => "required - What is the expected length of the serial number?",
                            "ticket_is_payable" => "Is this ticket paid for? (0 or 1)",
                            "ticket_amount" => "If paid, what is the amount to be paid for this ticket?"
                        ]
                    ]
                ],
                "PUT" => [
                    "update" => [
                        "params" => [
                            "ticket_title" => "required - The title for this ticket",
                            "quantity" => "required - The number of Tickets to be generated (default is 100)",
                            "ticket_is_payable" => "Is this ticket paid for?",
                            "ticket_amount" => "If paid, what is the amount to be paid for this ticket?",
                            "ticket_guid"=> "required - The unique guid of the ticket to load"
                        ]
                    ]
                ]
            ],
            "events" => [
                "GET" => [
                    "list" => [
                        "params" => [
                            "state" => "This is the filter applied to the state of the event",
                            "limit" => "The number of rows to return in the results",
                            "summary" => "This is an optional parameter to query",
                            "event_guid" => "The guid of the event to load the data"
                        ]
                    ]
                ],
                "POST" => [
                    "add" => [
                        "params" => [
                            "event_title" => "required - The name of the hall",
                            "department_guid" => "The guid of the department to attach this event",
                            "event_date" => "required - The date for which this event will be held",
                            "start_time" => "required - The starting time for the event",
                            "end_time" => "required - The end time for the event",
                            "halls_guid" => "required - The halls that will be used for this event",
                            "booking_starttime" => "required - The date and time begin booking",
                            "booking_endtime" => "required - The date and time to end booking",
                            "event_is_payable" => "Is the event payable (0 or 1)",
                            "ticket_guid" => "If payable, what then is the tickets for this event.",
                            "multiple_booking" => "Can a user make several bookings with the same contact number? (0 or 1)",
                            "maximum_booking" => "Whats the maximum number of bookings that a user can make.",
                            "attachment" => "Attach multiple images or videos to this event.",
                            "description" => "Sample description or information about this event.",
                        ]
                    ],
                    "update" => [
                        "params" => [
                            "event_title" => "required - The name of the hall",
                            "department_guid" => "The guid of the department to attach this event",
                            "event_date" => "required - The date for which this event will be held",
                            "start_time" => "required - The starting time for the event",
                            "end_time" => "required - The end time for the event",
                            "halls_guid" => "required - The halls that will be used for this event",
                            "booking_starttime" => "required - The date and time begin booking",
                            "booking_endtime" => "required - The date and time to end booking",
                            "event_is_payable" => "Is the event payable (0 or 1)",
                            "ticket_guid" => "If payable, what then is the tickets for this event.",
                            "multiple_booking" => "Can a user make several bookings with the same contact number? (0 or 1)",
                            "maximum_booking" => "Whats the maximum number of bookings that a user can make.",
                            "attachment" => "Attach multiple images or videos to this event.",
                            "description" => "Sample description or information about this event.",
                            "event_guid"=> "required - The unique guid of the hall",
                        ]
                    ],
                    "remove-attachment" => [
                        "params" => [
                            "event_guid" => "required - The event guid to delete."
                        ]
                    ]
                ]
            ],
            "settings" => [
                "POST" => [
                    "general" => [
                        "params" => [
                            "name" => "required - The name of the company",
                            "email" => "required - The email address of the company",
                            "primary_contact" => "required - The Primary Contact Number",
                            "secondary_contact" => "The Secondary Contact Number",
                            "website" => "The webiste url of the company",
                            "address" => "required - The Address of the company",
                            "logo" => "The Company Logo",
                            "color_picker" => "The preset colour option",
                            "color" => "The the preset colors",
                            "background_color" => "The the background color to use",
                            "bg_color_light" => "The the background light color to use",
                        ]
                    ]
                ]
            ],
            "remove" => [
                "DELETE" => [
                    "confirm" => [
                        "params" => [
                            "item" => "required - The Item Type to remove",
                            "item_id" => "required - The Item ID to Remove"
                        ]
                    ]
                ]
            ],
            "insight" => [
                "GET" => [
                    "report" => [
                        "params" => [
                            "tree" => "The data to return: to be comma separated (list, booking_summary, detail, booking_count, overall_summary) - Default is list.",
                            "event_guid" => "The event guid to load the data",
                            "period" => "The timeframe for the report to generate",
                            "order" => "The order for the results listing (ASC or DESC)"
                        ]
                    ]
                ]
            ],
            "account" => [
                "POST" => [
                    "select" => [
                        "params" => [
                            "accountId" => "required - This is the account that will be managed."
                        ]
                    ],
                    "connect" => [
                        "params" => [
                            "channel" => "required - This is the channel name to add",
                            "brand_id" => "required - This is the Brand Id to add",
                            "page_image" => "The image of the page",
                            "access_token" => "required - The access token",
                            "page_id" => "required - The unique id of the page",
                            "page_name" => "required - The name of the page.",
                            "user_id" => "required - The user id of the account to be added."
                        ]
                    ],
                    "update" => [
                        "params" => [
                            "logo" => "This is the logo of the firm",
                            "name" => "required - This is the channel name to add",
                            "account_type" => "This is the Brand Id to add",
                            "account_industry" => "The industry where the account falls",
                            "phone" => "required - The contact number of the account",
                            "email" => "required - The default email of the account.",
                            "country" => "The country of the registering user account.",
                            "city" => "The city of the registering user account."
                        ]
                    ]
                ]
            ],
            "sms" => [
                "GET" => [
                    "check-balance" => [
                        "description" => "Check the SMS Unit balance for this account"
                    ],
                    "history" => [
                        "description" => "Get the SMS History sent from this account",
                        "params" => [
                            "limit" => "The number of rows to return in the results",
                            "group" => "Could either be bulk or single"
                        ]
                    ],
                    "category" => [
                        "params" => [
                            "msg_type" => "required - This is the type of message to send",
                            "recipient" => "required - The receipient group to receive the message."
                        ]
                    ]
                ],
                "POST" => [
                    "send" => [
                        "params" => [
                            "message" => "required - The message to send",
                            "recipients" => "The recipients to receive the message",
                            "category" => "required - The category of messages to receive",
                            "data" => "This is an additional data to parse together with the recipient category",
                            "unit" => "The unit of messages to send out to the uses."
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * This method checks the params parsed by the user
     *  @param {array} $params  This is the array of parameters sent by the user
    */
    public function keysChecker(array $params) {
        
        /**
         * check if there is a valid request method in the endpoints
         * 
         * Return an error / success message with a specific code
         */
        if( !isset($this->endpoints[$this->inner_url]) ) {
            return $this->output(400, ['accepted' => ["endpoints" => array_keys( $this->endpoints ) ] ]);
        }
        elseif( !isset( $this->endpoints[$this->inner_url][$this->method] ) ) {
            return $this->output(400, ['accepted' => ["method" => array_keys( $this->endpoints[$this->inner_url] ) ] ]);
        }
        // continue process
        elseif(!isset($this->endpoints[$this->inner_url][$this->method][$this->outer_url])) {
            return $this->output(404, ['accepted' => ["endpoints" => array_keys( $this->endpoints[$this->inner_url][$this->method] ) ] ]);
        } else {
            // set the acceptable parameters
            $accepted =  $this->endpoints[$this->inner_url][$this->method][$this->outer_url];

            // confirm that the parameters parsed is not more than the accpetable ones
            if( !isset($accepted['params']) ) {
                // return all tests parsed
                return $this->output(100);
            } elseif( count($params) > count($accepted['params'])) {
                return $this->output(405, ['accepted' => ["parameters" => $accepted['params'] ]]);
            } else {
                // get the keys of all the acceptable parameters
                $endpointKeys = array_keys($accepted['params']);
                $errorFound = false;
                
                // confirm that the supplied parameters are within the list of expected parameters
                foreach($params as $key => $value) {
                    if(!in_array($key, $endpointKeys)) {
                        $errorFound = true;                        
                        // break the loop
                        break;
                    }
                }

                // if an invalid parameter was parsed
                if($errorFound) {
                    return $this->output(405, ['accepted' => ["parameters" => $accepted['params'] ]]);
                } else {

                    /**
                     * Check if all the required parameters was parsed
                     * This section is necessary considering the following example
                     * 
                     * user parsed - 
                     * $params["firstname"] = Emmanuel Obeng,
                     * $params["age"] = 28
                     * 
                     * This will pass the first test because the count is 2 as compared to the acceptable of 3
                     * Likewise all the keys are within the the set of {firstname, lastname and age}
                     * 
                     * However the lastname is required but was not parsed by the user. So we need to verify it.
                     *
                    */ 
                    /* Set the required into an empty array list */
                    $required = [];
                    $required_text = [];

                    // loop through the accepted parameters and check which one has the description 
                    // required and append to the list
                    foreach($accepted['params'] as $key => $value) {
                        
                        // evaluates to true
                        if( strpos($value, "required") !== false) {
                            $required[] = $key;
                            $required_text[] = $key . ": " . str_replace(["required", "-"], "", $value);
                        }
                    }

                    /**
                     * Confirm the count using an array_intersect
                     * What is happening
                     * 
                     * Get the keys of the parsed parameters
                     * count the number of times the required keys appeared in it
                     * 
                     * compare to the count of the required keys if it matches.
                     * 
                     */
                    $confirm = (count(array_intersect($required, array_keys($params))) == count($required));

                    // If it does not evaluate to true
                    if(!$confirm) {
                        return $this->output(401, ['required' => $required_text]);
                    } else {
                        // return all tests parsed
                        return $this->output(100);
                    }

                }
            }
        }

    }

    /**
     * This handles all requests by redirecting it to the appropriate
     * Controller class for that particular endpoint request
     * @param array $params         - This the array of parameters that the user parsed in the request
     * @return  
     */
    final function apiHandler(array $params, $remote) {
        // preset the response
        $result = [];
        $code = 500;

        $this->requestPayload = $params;

        // convert the params to an object
        $params = (Object) $params;
        $params->clientId = $this->clientId;
        $params->userId = $this->userId;
        $params->remote = $remote;

        // client information
        $params->curUserId = $this->userId;

        if(empty($this->clientId) && (($this->outer_url !== "select" && $this->inner_url !== "account")) && (($this->inner_url !== "reservations"))) {
            return $this->output($code, $result);
        }

        // check if the users endpoint was parsed
        if( $this->inner_url == "users" ) {
            
            // require the class
            global $usersClass;
            
            // or you can do that straight forward from here
            if( $this->outer_url == "list" ) {
                
                // limit parameter
                $params->limit = !empty($params->limit) ? $params->limit : 200;

                // update the user theme color
                $request = $usersClass->listUsers($params);

                // if the request was successful
                if($request) {
                    $result['result'] = $request;
                    $code = 200;
                }
            }

            // or you can do that straight forward from here
            elseif( $this->outer_url == "theme" ) {
                // update the user theme color
                $request = $usersClass->updateUserTheme($params);

                // if the request was successful
                if($request) {
                    $code = 205;
                }
            }

            // if the user is updating a user profile
            elseif( $this->outer_url == "update") {

                // if the user does not have access level access but tried to push it
                if(!$this->accessCheck->hasAccess("accesslevel", "users")) {
                    // then remove it from the list of parameters
                    $params->access_level = (!empty($params->access_level)) ? null : null;
                    $params->access_level_id = (!empty($params->access_level_id)) ? null : null;
                }
                // parse the request to update the user profile information
                $request = $usersClass->updateUserProfile($params);

                // confirm the request processing
                if($request === "invalid-phone") {
                    $result['result'] = "Sorry please enter a valid Contact Number.";
                }
                elseif($request === "invalid-email") {
                    $result['result'] = "Sorry please enter a valid Email Address.";
                }
                elseif($request === "invalid-access_levels") {
                    $result['result'] = "Sorry the Access Level permissions must be an array.";
                }
                elseif($request === "unknown-error") {
                    $result['result'] = "Sorry an unknown error occured. Please try again later";
                }
                elseif($request === "invalid") {
                    $result['result'] = "Sorry an invalid user id was parsed for processing";
                }
                // if the request was successful
                else {
                    $result['result'] = "Profile was successfully updated.";
                    $result['remote_request']['reload'] = true;
                    $result['remote_request']['href'] = $this->session->current_url;
                    $code = 200;
                }
                
                
            }
            
            // if a request is made for the activity logs history
            elseif( $this->outer_url == "history") {
                
                // convert the data into an object
                $params = (object) $params;
                $params->limit = (!empty($params->limit)) ? (int) $params->limit : 100;
                $params->clientId = $this->session->clientId;

                // parse the request to update the user profile information
                $request = $usersClass->userActivityLogs($params);

                // if the request was successful
                if($request) {
                    $code = 200;
                    $result['result'] = $request;
                } else {
                    $code = 201;
                }
            }

            // if a request is made for the access level details
            elseif($this->outer_url == "access_levels_list") {

                // parse the request to update the user profile information
                if(isset($params->level_id)) {
                    $request = $usersClass->userAccessLevels($params);
                } else {
                    $request = null;
                }

                 // if the request was successful
                 if($request) {
                    $code = 200;
                    $result['result'] = $request;
                } else {
                    $result['result'] = '<div class="text-center"><em>No privileges selected</em></div>';
                }

            }

            // access permissions
            elseif($this->outer_url == "access_levels") {

                // if the user does not have access level access but tried to push it
                if(!$this->accessCheck->hasAccess("accesslevel", "users")) {
                    // then remove it from the list of parameters
                    $result['result'] = self::PERMISSION_DENIED;
                }
                else {
                    // parse the request to update the user profile information
                    $request = $usersClass->savePermissions($params);
                    
                    // get the response
                    if($request === "error") {
                        // permission denied message
                        $result['result'] = "Sorry! An error occured while saving the data";
                    } elseif($request === "no-permission") {
                        // permission denied message
                        $result['result'] = "Sorry! No Permission Found.";
                    } else {
                        $result['result'] = $request;
                        $code = 200;
                    }
                    
                }
            }

            // change password
            elseif($this->outer_url == "change_password") {

                // if the user does not have access level access but tried to push it
                // parse the request to update the user profile information
                $request = $usersClass->changePassword($params);
                
                // get the response
                if($request === "match-error") {
                    // permission denied message
                    $result['result'] = "Sorry! The passwords entered do not match";
                } elseif($request == "strength-error") {
                    $result['result'] = "Sorry! The password must be at least 8 characters long and contain an uppercase and lowercase characters and numeric integer.";
                } elseif($request == "user-error") {
                    $result['result'] = "Sorry! You have supplied an invalid user id.";
                }else {
                    $result['result'] = $request;
                    $result['remote_request']['clear'] = "clear()";
                    $code = 200;
                }
            }

            // if the user is updating a user profile
            elseif( $this->outer_url == "add") {
                
                // convert the data to an object
                $params->clientId = $this->session->clientId;
                $params->curUserId = $this->userId;
                
                // if the user does not have the required permissions
                if(!$this->accessCheck->hasAccess("manage", "users")) {
                    // permission denied message
                    $result['result'] = self::PERMISSION_DENIED;
                } else {

                    // parse the request to update the user profile information
                    $request = $usersClass->addUserProfile($params);
                    
                    if($request == "invalid-phone") {
                        $result['result'] = "Sorry please enter a valid Contact Number.";
                    }
                    elseif($request == "invalid-email") {
                        $result['result'] = "Sorry please enter a valid Email Address.";
                    }
                    elseif($request === "invalid-access_levels") {
                        $result['result'] = "Sorry the Access Level permissions must be an array.";
                    }
                    elseif($request === "unknown-error") {
                        $result['result'] = "Sorry an unknown error occured. Please try again later";
                    }
                    // confirm the request processing
                    elseif($request === "account-created") {
                        $result['result'] = "User Account was successfully Created.";
                        $result['remote_request']['reload'] = true;
                        $result['remote_request']['href'] = $this->config->base_url("users");
                        $code = 200;
                    }
                    else {
                        $result['result'] = $request;
                    }
                }
            

            }

            // access permissions
            elseif($this->outer_url == "permissions") {
                // if the user does not have access level access but tried to push it
                if(!$this->accessCheck->hasAccess("accesslevel", "users")) {
                    // then remove it from the list of parameters
                    $result['result'] = self::PERMISSION_DENIED;
                }
                else {
                    // parse the request to update the user profile information
                    $request = $usersClass->loadPermissions($params);
                    
                    // get the response
                    if($request === "no-user") {
                        // permission denied message
                        $result['result'] = "Sorry! No Permission Found For This User";
                    } elseif($request === "no-permission") {
                        // permission denied message
                        $result['result'] = "Sorry! No Permission Found.";
                    } else {
                        $result['result'] = $request;
                        $code = 200;
                    }
                }
            }

        } 

        // check if the users endpoint was parsed
        elseif( in_array($this->inner_url, ["events", "halls", "tickets", "reservations", "departments"]) ) {
            
            // require the class
            $objectClass = load_class($this->inner_url, "controllers");
            
            // or you can do that straight forward from here
            if( $this->outer_url == "list" ) {
                
                // limit parameter
                $params->limit = !empty($params->limit) ? $params->limit : 500;

                // update the user theme color
                $request = $objectClass->listItems($params);

                // if the request was successful
                if($request) {
                    $result['result'] = $request;
                    $code = 200;
                }
            }

            // generate a tickets using the predefined parameters
            elseif( ($this->inner_url == "tickets") && ($this->outer_url == "generate") ) {
                // limit parameter
                $params->limit = !empty($params->limit) ? $params->limit : 500;

                // update the user theme color
                $request = $objectClass->generateTickets($params);

                // if the request was successful
                if($request) {
                    // confirm that an array was parsed as the response
                    if(!is_array($request)) {
                        $result['result'] = $request;
                    } else {
                        $result['result'] = $request['msg'];
                        $result['remote_request']['reload'] = true;
                        $result['remote_request']['clear'] = true;
                        $result['remote_request']['href'] = $this->config->base_url($this->inner_url);
                        $code = 200;
                    }
                }
            }

            // ticket configuration
            elseif(($this->inner_url == "tickets") && ($this->outer_url == "activate")) {
                // update the user theme color
                $request = $objectClass->activateTicket($params);

                // if the request was successful
                if($request) {
                    $result['result'] = "The Ticket was successfully activated and can now be used.";
                    $code = 200;
                }
            }

            // sell out a ticket
            elseif(($this->inner_url == "tickets") && ($this->outer_url == "sell")) {
                // sell out the ticket
                $request = $objectClass->sellTicket($params);

                // if the request was successful
                if(is_array($request)) {
                    $code = 200;
                    $result['result'] = $request['result'];
                    $result['remote_request']['reload'] = true;
                    $result['additional'] = $request['event_data'];
                    $result['remote_request']['href'] = $this->config->base_url("tickets-list");
                } else {
                    $result['result'] = $request;
                }
            }

            // list of tickets sold
            elseif($this->inner_url == "tickets" && $this->outer_url == "sales-list") {
                // limit parameter
                $params->limit = !empty($params->limit) ? $params->limit : 500;

                // update the user theme color
                $request = $objectClass->listSales($params);

                // if the request was successful
                if($request) {
                    $result['result'] = $request;
                    $code = 200;
                }
            }

            // ticket validation
            elseif(($this->inner_url == "tickets") && ($this->outer_url == "validate")) {
                // update the user theme color
                $request = $objectClass->validateTicket($params);

                // if the request was successful
                if($request) {
                    $result['result'] = $request;

                    if($request == "Ticket successfully validated") {
                        $result['remote_request']['reload'] = true;
                        $result['remote_request']['href'] = $this->session->current_url;
                        $code = 200;
                    }                    
                }
            }

            // reserve a seat
            elseif( ($this->inner_url == "reservations") && ($this->outer_url == "reserve") ) {
                
                // update the user theme color
                $request = $objectClass->reserveSeat($params);
                
                // if the request was successful
                if($request == "perfect") {
                    $result['result'] = "Congrats, Your booking was successful";
                    $code = 200;
                } else {
                    $result['result'] = $request;
                }
            }

            // activate a hall
            elseif( ($this->inner_url == "halls") && ($this->outer_url == "configure") ) {
                
                // if the user does not have access level access but tried to push it
                if(!$this->accessCheck->hasAccess("configure", $this->inner_url)) {
                    // permission denied message
                    $result['result'] = self::PERMISSION_DENIED;
                } else {
                    // update the user theme color
                    $request = $objectClass->configureHall($params);

                    // confirm the request processing
                    if(is_array($request)) {
                        
                        // if the response is not successful
                        if($request['state'] != 200) {
                            $result['result'] = $request['msg'];
                        } else {
                            $result['result'] = $request['msg'];
                            $result['remote_request']['reload'] = true;
                            $result['remote_request']['clear'] = true;
                            $result['remote_request']['href'] = $this->config->base_url("halls-configuration/{$params->hall_guid}");
                            $code = 200;
                        }
                        
                    } else {
                        $result['result'] = $request;
                    }
                }
            }

            // hall configuration
            elseif(($this->inner_url == "halls") && ($this->outer_url == "activate")) {
                // update the user theme color
                $request = $objectClass->activateHall($params);

                // if the request was successful
                if($request) {
                    $result['result'] = "The hall was successfully activated";
                    $code = 200;
                }
            }

            // hall configuration
            elseif(($this->inner_url == "halls") && ($this->outer_url == "reset")) {

                // update the user theme color
                $request = $objectClass->resetHall($params);
                
                // if the request was successful
                if($request) {
                    $result['result'] = "The hall was successfully resetted";
                    $code = 200;
                }
            }

            // remove event attachment
            elseif(($this->inner_url == "events") && ($this->outer_url == "remove-attachment")) {
                // if the user does not have access level access but tried to push it
                if(!$this->accessCheck->hasAccess("update", "events")) {
                    // then remove it from the list of parameters
                    $result['result'] = self::PERMISSION_DENIED;
                }
                else {
                    // parse the request to update the user profile information
                    $request = $objectClass->removeAttachment($params);
                    
                    // get the response
                    if($request) {
                        $result['result'] = "Event attachment successfully removed";
                        $code = 200;
                    }
                }
            }

            // if the user is updating a branch
            elseif( $this->outer_url == "update") {
                // client information
                $params->curUserId = $this->userId;

                // if the user does not have access level access but tried to push it
                if(!$this->accessCheck->hasAccess("update", $this->inner_url)) {
                    // permission denied message
                    $result['result'] = self::PERMISSION_DENIED;
                } else {
                    // parse the request to update the user profile information
                    $request = $objectClass->updateItem($params);

                    // confirm the request processing
                    if(is_array($request)) {

                        // confirm the request processing
                        if($request['state'] != 200) {
                            $result['result'] = $request['msg'];
                        } else {
                            $result['result'] = $request['msg'];
                            $code = 200;
                        }
                    } else {
                        $result['result'] = $request;
                    }
                }
            }

            // if the user is updating a branch
            elseif( $this->outer_url == "add") {
                // client information
                $params->curUserId = $this->userId;

                // if the user does not have access level access but tried to push it
                // TODO:: Access Permissions Checker
                if(!$this->accessCheck->hasAccess("add", $this->inner_url)) {
                    // permission denied message
                    $result['result'] = self::PERMISSION_DENIED;
                } else {
                    // parse the request to update the user profile information
                    $request = $objectClass->addItem($params);

                    // confirm the request processing
                    if(is_array($request)) {
                        
                        // if the response is not successful
                        if($request['state'] != 200) {
                            $result['result'] = $request['msg'];
                        } else {
                            $result['result'] = $request['msg'];
                            $result['remote_request']['reload'] = true;
                            $result['remote_request']['clear'] = true;
                            $result['remote_request']['href'] = $this->config->base_url($this->inner_url);
                            $code = 200;
                        }
                        
                    } else {
                        $result['result'] = $request;
                    }
                }                
            }
            
        }

        // insight endpoint
        elseif( $this->inner_url == "insight" ) {
            
            // create a new object
            $insightObj = load_class("insight", "controllers");
            $request = $insightObj->generateInsight($params);

            if($request) {
                $result['result'] = $request;
                $code = 200;
            }
            
        }

        // if the user is managing an account
        elseif ( $this->inner_url == "account" ) {
            
            // require the class
            global $usersClass;

            // or you can do that straight forward from here
            if( $this->outer_url == "select" ) {

                // get the list of user brands
                $request = $usersClass->selectAccount($params);

                // if the request was successful
                if($request) {
                    $code = 200;
                }
            }

            // connect an account
            elseif( $this->outer_url == "connect" ) {

                // create a new object
                $accountClass = load_class('accounts', 'controllers');

                // set additional values
                $params = (Object) $params;
                $params->userId = $this->userId;
                $params->clientId = $this->clientId;

                // if the user does not have the required permissions
                if(!$this->accessCheck->hasAccess("connect", "channels")) {
                    // permission denied message
                    $result['result'] = self::PERMISSION_DENIED;
                } else {

                    // parse the request to connect an account
                    $request = $accountClass->linkAccount($params);

                    // if the query was successful
                    if($request) {

                        // unset all sessions
                        $this->session->remove("facebookArray");
                        $this->session->remove("facebook_access_token");
                        $this->session->remove("facebook_user_id");
                        $this->session->remove("FBRLH_state");
                        $this->session->remove("expiresIn");
                        $this->session->remove("youtubeAccessToken");
                        $this->session->remove("userInformation");
		                $this->session->remove("channelsList");

                        // unset the brands list session data
                        $this->session->remove("brandsListData");

                        // parse the success response
                        $code = 200;
                        $result['remote_request']['reload'] = true;
                        $result['remote_request']['href'] = $this->config->base_url('channels/'.$params->brand_id);
                        $result['result'] = ucfirst($params->channel) . " was successfully connected.";
                    }
                }
            }
            
            // update a account details
            elseif( $this->outer_url == "update" ) {

                // convert the array to object
                $params = (Object) $params;
                $params->userId = $this->userId;
                $params->clientId = $this->clientId;

                // create a new object
                $accountClass = load_class('accounts', 'controllers');

                // if the user does not have the required permissions
                if(!$this->accessCheck->hasAccess("manage", "account")) {
                    // permission denied message
                    $result['result'] = self::PERMISSION_DENIED;
                } else {
                    // update the account details
                    $request = $accountClass->updateAccount($params);
                    
                    // confirm the request processing
                    if($request === "invalid-phone") {
                        $result['result'] = "Sorry please enter a valid Contact Number.";
                    }
                    elseif($request === "invalid-email") {
                        $result['result'] = "Sorry please enter a valid Email Number.";
                    }
                    // if the request was successful
                    else {
                        $result['result'] = "Account was successfully updated.";
                        $code = 200;
                        // refresh the page if a logo was submitted
                        if($request == "refresh") {
                            $result['remote_request']['reload'] = true;
                            $result['remote_request']['href'] = $this->session->current_url;
                        }
                    }
                }
            }
        }

        // communication handler
        elseif(in_array($this->inner_url, ["sms", "emails"])) {

            // create a new communcation class
            $commObj = load_class('communication', 'controllers');

            // check the balance of the sms units
            if($this->outer_url == "check-balance") {
                $request = $commObj->checkBalance($params);
                if($request) {
                    $code = 200;
                    $result['result'] = $request;
                }
            }

            // list sms category listing
            elseif($this->outer_url == "category") {
                $request = $commObj->recipientCategory($params);
                if($request) {
                    $code = 200;
                    $result['result'] = $request;
                }
            }
            
            // list the history of the messages
            elseif($this->outer_url == "history") {
                $request = $commObj->smsHistory($params);
                if($request) {
                    $code = 200;
                    $result['result'] = $request;
                }
            }

            // send the message out
            elseif($this->inner_url == "sms" && $this->outer_url == "send") {

                // Check Access Level
                if(!$this->accessCheck->hasAccess('manage', 'communications')) {
                    // permission denied message
                    $result['result'] = self::PERMISSION_DENIED;
                } else {
                    $request = $commObj->smsSend($params);

                    if(is_array($request)) {
                        $code = 200;
                        $result['result'] = $request;
                    } else {
                        $result['result'] = $request;
                    }
                }
            }
        }

        // if the user want remove an item from the database
        elseif( $this->inner_url == "remove" ) {
            
            // confirm that the user has the permission to perform the action
            if((!in_array($params->item, ["cancel-event","confirm-booking","remove-booking","event-media", "return-ticket"])) && !$this->accessCheck->hasAccess("delete", "{$params->item}s")) {
                // permission denied message
                $result['result'] = self::PERMISSION_DENIED;
            }
            // if the events is to canceled
            elseif(in_array($params->item, ["cancel-event","event-media"]) && !$this->accessCheck->hasAccess("delete", "events")) {
                // permission denied message
                $result['result'] = self::PERMISSION_DENIED;
            }
            // return tickets
            elseif(in_array($params->item, ["return-ticket"]) && !$this->accessCheck->hasAccess("return", "tickets")) {
                // permission denied message
                $result['result'] = self::PERMISSION_DENIED;
            } else {
                
                // process the user request
                $request = $this->bookingClass->removeRecord($params);
                
                // processing the request
                if($request === "denied") {
                    $result['result'] = self::PERMISSION_DENIED;
                } elseif($request === "great") {
                    $code = 200;
                    if($params->item == "cancel-event") {
                        $result['result'] = "The event was successfully cancelled.";
                    } elseif($params->item == "confirm-booking") {
                        $result['result'] = "The Booking was successfully confirmed.";
                    } elseif($params->item == "remove-booking") {
                        $result['result'] = "The Booked Seat was successfully reversed.";
                    } else {
                        $result['result'] = "The ".ucfirst($params->item)." was successfully deleted";
                    }
                } else {
                    $result['result'] = "Sorry! Your request could not be processed. Please try again later.";
                }
            }
        }

        if(!empty($this->requestPayload)) {
            $result['remote_request']['payload'] = $this->requestPayload;
        }

        $code = !empty($code) ? $code : 201;

        // set the value for the data
        if( $code == 201 ) {
            $result['result'] = 'The request was successful however, no results was found.';
        }

        return $this->output($code, $result);
    }

    /**
     * Outputs to the screen
     * 
     * @param {int}             $code   This is the code after processing the user request
     * @param {string/array}    $data   Any addition data to parse to the user
     */
    private function output($code, $message = null) {
        $data = [
            'code' => $code,
            'description' => $this->outputMessage($code),
            'method' => $this->method,
            'endpoint' => trim($_SERVER["REQUEST_URI"], "?")
        ];

        ( !empty($message) ) ? ($data['data'] = $message) : null;

        return $data;
    }

    private function outputMessage($code) {

        $description = [
            200 => 'The request was successfully executed and returned some results.',
            201 => 'The request was successful however, no results was found.',
            205 => 'The record was successfully updated.',
            202 => 'The data was successfully inserted into the database.',
            203 => 'Sorry! An error was encountered while processing the request.',
            400 => 'Invalid request method parsed.',
            401 => 'Sorry! Some required parameters were not supplied. (Ensure fields are not empty)',
            404 => 'Invalid request node parsed.',
            405 => 'Invalid parameters was parsed to the endpoint.',
            100 => 'All tests parsed',
            501 => "Sorry! You do not have the required permissions to perform this action.",
            600 => "Sorry! Your current subscription does not grant you permission to perform this action.",
            700 => "Unknown request parsed",
            999 => "An error occurred please try again later"
        ];

        return $description[$code] ?? $description[700];
    }

}
?>