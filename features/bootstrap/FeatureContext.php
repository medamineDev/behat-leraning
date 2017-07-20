<?php


use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use GuzzleHttp\Client;


use Ulff\BehatRestApiExtension\Context\RestApiContext;




class FeatureContext extends RestApiContext implements Context
{


    private $output;


    /**
     * Initializes context.
     * Every scenario gets its own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */



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




      //  dd($array->user);

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
