<?php
/*
 * Local configuration file to provide any overrides to your app.php configuration.
 * Copy and save this file as app_local.php and make changes as required.
 * Note: It is not recommended to commit files with credentials such as app_local.php
 * into source code version control.
 */
return [
    /*
     * Debug Level:
     *
     * Production Mode:
     * false: No error messages, errors, or warnings shown.
     *
     * Development Mode:
     * true: Errors and warnings shown.
     */
  //  'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN), //Commented on 13-04-2022 Shweta Apale
	
	'debug' => filter_var(env('PROD', false), FILTER_VALIDATE_BOOLEAN), // Added this line on 13-04-2022 to avoid warning Shweta Apale

    /*
     * Security and encryption configuration
     *
     * - salt - A random string used in security hashing methods.
     *   The salt value is also used as the encryption key.
     *   You should treat it as extremely sensitive data.
     */
    'Security' => [
        'salt' => env('SECURITY_SALT', '2199dd7247a09fe42aedfe59b59ee305eb02b95c30b2e7f4c5b129a3d58f0c64'),
    ],

    /*
     * Connection information used by the ORM to connect
     * to your application's datastores.
     *
     * See app.php for more configuration options.
     */
    'Datasources' => [
        'default' => [
            'host' => '10.158.81.29',
            /*
             * CakePHP will use the default DB port based on the driver selected
             * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
             * the following line and set the port accordingly
             */
            //'port' => 'non_standard_port_number',

            'username' => 'root',
            'password' => '',

          //  'database' => 'ibmphasetwo',
		  'database' => 'rmslive',
		  
            /*
             * If not using the default 'public' schema with the PostgreSQL driver
             * set it here.
             */
            //'schema' => 'myapp',

            /*
             * You can use a DSN string to set the entire configuration
             */
            'url' => env('DATABASE_URL', null),
        ],

        /*
         * The test connection is used during the test suite.
         */
        'ibmreg' => [
            'host' => '10.194.73.125',
            //'port' => 'non_standard_port_number',
            'username' => 'mysql',
            'password' => 'nagpur123',
            'database' => 'ibmregistration',
            //'schema' => 'myapp',
            'url' => env('DATABASE_URL', null),
        ],
		
        'mpas' => [
            'host' => '10.194.73.127',
            //'port' => 'non_standard_port_number',
            'username' => 'root',
            'password' => 'nagpur123',
            'database' => 'miningplanlive',
            //'schema' => 'myapp',
            'url' => env('DATABASE_URL', null),
        ],
        
		'oldconn' => [
            'host' => '10.194.73.125',
            //'port' => 'non_standard_port_number',
            'username' => 'root',
            'password' => 'mypassword123',
            'database' => 'returnsaudit',
            //'schema' => 'myapp',
            'url' => env('DATABASE_URL', null),
        ],
    ],

    /*
     * Email configuration.
     *
     * Host and credential configuration in case you are using SmtpTransport
     *
     * See app.php for more configuration options.
     */
    'EmailTransport' => [
        'default' => [
            'host' => 'localhost',
            'port' => 25,
            'username' => null,
            'password' => null,
            'client' => null,
            'url' => env('EMAIL_TRANSPORT_DEFAULT_URL', null),
        ],
    ],
];
