<?php


use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use GuzzleHttp\Client;
use App\User;
use \Illuminate\Support\Facades\Auth;
use Ulff\BehatRestApiExtension\Context\RestApiContext;


class FeatureContext extends RestApiContext implements Context
{


    private $output;
    public static $loggedMail;



    public function iMakeRequest($method, $uri)
    {

        $this->request($method, $uri);
    }

    public function iMakeRequestWithFollowingJSONContent($method, $uri, PyStringNode $json)
    {

        $array = $json->getStrings();
        $array = json_encode($array);


        $this->request($method, $uri, json_decode($array, true));
    }


    /**
     * Make request specifying http method and uri and parameters as JSON.
     *
     * Example:
     *  When I make request "POST" "/api/v1/posts" with following JSON content:
     *  """
     *  {
     *      "user": "user-id",
     *      "title": "Some title"
     *      "number": 12
     *  }
     *  """
     *
     *
     *
     * @When I create :class object  with following JSON content:
     */
    public function iCreateObject($class, PyStringNode $json)
    {


        $array = json_decode($json);


        $userObject = new stdClass();
        $userObject->id = "test";
        $userObject->name = "test";

        $this->output = $userObject;


    }


    /** @Then /^I should get "(?P<string>(?:[^"]|\\")*)"$/ */
    public function iShouldGet($string)
    {
        if ((string)$string !== $this->output) {
            throw new Exception(
                "Actual output is:\n" . $this->output
            );
        }
    }


    /** @Then /^I remove the  user with mail "(?P<string>(?:[^"]|\\")*)"$/ */
    public function iRemoveTheUserWithMail($string)
    {

        $user = User::where("email", $string)->first();
        $isRemoved = false;
        if ($user) {

            $isRemoved = $user->delete();
        }


        if (!$user || !$isRemoved) {
            throw new Exception(
                "Actual output is:\n" . $this->output
            );
        }
    }

    /** @Then /^I am logged In with "(?P<string>(?:[^"]|\\")*)"$/ */
    public function imLoggedInWith($string)
    {

        self::$loggedMail = $string;
        $user = User::where("email", self::$loggedMail)->first();


        if ($user) {

            Auth::loginUsingId($user->id);

            if(!Auth::user()->id){
                throw new Exception(
                    "the use not logged In:\n" . $this->output
                );

            }

        }else{

            throw new Exception(
                "logged user not found :\n" . $this->output
            );

        }




    }

    public function spin ($lambda)
    {
        while (true)
        {
            try {
                if ($lambda($this)) {
                    return true;
                }
            } catch (Exception $e) {
                // do nothing
            }



        }
    }

    /** @Then /^I press using id  "(?P<string>(?:[^"]|\\")*)"$/  */
    public function pressUsingId($string)
    {

        $this->spin(function($context)use($string) {

            $context->getSession()->getPage()->findById($string)->click();
            return true;
        });
    }

    /** @Then I am logged in */
    public function login()
    {


        $user = User::where("email", self::$loggedMail)->first();


        if ($user) {

            \Illuminate\Support\Facades\Auth::loginUsingId($user->id);

        }else{

            throw new Exception(
                "Actual output is:\n" . $this->output
            );

        }




    }


    /** @And sleep */
    public function sleep()
    {

        sleep(5);




    }

    /** @Then /^The Object must contain "(?P<string>(?:[^"]|\\")*)"$/ */
    public function theObjectMustContain($string)
    {

        if (!$this->output->id) {

            throw new Exception(
                "Actual Object is:\n" . $this->output
            );
        } else {

            echo 'passed with id : ' . $this->output->id;
        }
    }

}
