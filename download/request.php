<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type"
              content="text/html; charset=utf-8"/>
        <link href="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/css/bootstrap-combined.min.css" rel="stylesheet">
        <?php
        //
        // Please download the Paymill PHP Wrapper at
        // https://github.com/paymill/paymill-php
        // and put the containing "lib" folder into your project
        //
        require './paymill-php-master/autoload.php';
        //insert your private key instead of <YOUR_API_KEY>
        define('PAYMILL_API_HOST', 'https://api.paymill.com/v2/');
        define('PAYMILL_API_KEY', '<YOUR_API_KEY>');

        set_include_path(
            implode(PATH_SEPARATOR, array(
                realpath(realpath(dirname(__FILE__)).'/lib'),
                get_include_path())
            )
        );

        if ($token = $_POST['paymillToken']) {

          // create new request using your API Key
          $request = new \Paymill\Request(PAYMILL_API_KEY);

            // create a new transaction object and supply it with values
            $transactionObject = new \Paymill\Models\Request\Transaction();
            $transactionObject->setAmount(4200);
            $transactionObject->setCurrency('EUR');
            $transactionObject->setToken($token);
            $transactionObject->setDescription('Test Transaction');

            try{
              // create the transaction with the parameters supplied before
              $response = $request->create($transactionObject);
              // get the id from the object to display it
              $transactionId = $response->getId();
            } catch (\Paymill\Services\PaymillException $e) {
              $e -> getResponseCode();
              $e -> getStatusCode();
              $e -> getErrorMessage();
              $e -> getRawError();
            }

         }

         else {
           echo "something went wrong. Did you supply the paymillToken?";
         }
        ?>
    </head>
    <body>
        <div class="container">
            <h1>We appreciate your purchase!</h1>

            <h4>Transaction:</h4>
            <pre>
               <?php
               // here you can display whatever values you wish. For the example only the ID is displayed
               print_r($transactionId); ?>
            </pre>
        </div>
        <script src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.2.1/js/bootstrap.min.js"></script>
    </body>
</html>
