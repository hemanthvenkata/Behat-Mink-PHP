<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Context\Context;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext
{
    private $output='checked';


    /**
    * Click on the element with the provided xpath query
    * @When /^I click on the hamburger element with title as "([^"]*)"$/
    * @param $xpath
    */
    public function iClickOnTheElementWithXPath($xpath)
    {
        $session = $this->getSession(); // get the mink session
        $session->getDriver()->maximizeWindow();

        //click the hamburger menu
        $session->getPage()->find('css','.hamburger')->click();

        $this->waitUntilElementLoaded('global');

        $element = $session->getPage()->find('xpath','//nav[@id="global"]//a[@title="'.$xpath.'"]');

        // errors must not pass silently
        if (null === $element) {
           throw new \InvalidArgumentException(sprintf('Could not evaluate XPath: "%s"', $xpath));
        }

        $element->click();
        $this->waitUntilPageLoaded();
    }

    /**                                                                                        
     * This methods makes selects the first checkbox.                                
     * @When /^I click on the first checkbox$/
     */                                                                                        
    public function iClickOnTheFirstCheckbox()                                                   
    {
        $session = $this->getSession(); // get the mink session
        $session->getDriver()->maximizeWindow();
        
        $element = $session->getPage()->findAll('css','#the_forms_id input[type="checkbox"]');

        // errors must not pass silently
       if (null === $element && count($element) ==0) {
           throw new \InvalidArgumentException(sprintf('No Elements found to check'));
       }

       $element[0]->click();                                                                                
    } 

    /**
     * Checks, that first checkbox is checked.
     * @Then /^The first checkbox should be checked$/
     */
    public function assertCheckboxChecked()
    {

        $session = $this->getSession(); // get the mink session
        
        $element = $session->getPage()->findAll('css','#the_forms_id input[type="checkbox"]');

        // errors must not pass silently
       if (null === $element && count($element) ==0) {
           throw new \InvalidArgumentException(sprintf('No Elements found to check'));
       }
       assertEquals($element[0]->getAttribute("checked"), $this->output);
    }

   
   /**                                                                                        
     * This methods wait until the body element is present.                    
     * This supposes that the html is loaded (even if it's not 100% reliable).            
     *                                                                                         
     * @return bool                                                                            
     */                                                                                        
    protected function waitUntilPageLoaded()                                                   
    {
        $this->spin(                                                                           
            function ($context) {                                                              
                $context->assertSession()->elementExists('xpath', '//body');                   
                return true;                                                                   
            }                                                                                  
        );                                                                                     
    } 

    /**                                                                                        
     * This methods makes Selenium2 wait until the body element is present.                    
     * This supposes that the html is loaded (even if it's not 100% reliable).            
     *                                                                                         
     * @return bool                                                                            
     */                                                                                        
    protected function waitUntilElementLoaded($text)                                                   
    {
        $this->spin(                                                                           
            function ($context) use ($text){                                                              
                $context->getSession()->getPage()->findById($text)->isVisible();                  
                return true;                                                                   
            }                                                                                  
        );                                                                                     
    }        

/**                                                                                        
     * This function prevents Behat form failing a tests if the HTML is not loaded yet.        
     * Behat with Selenium often executes tests faster thant Selenium is able to retreive      
     * the HTML causing false negatives.                                                       
     *                                                                                         
     * Use this for all test cases that depend on a presence of some elements on the           
     * website.                                                                                
     *                                                                                         
     * Pass an anonymous function containing your normal test as an argument.                  
     * The function needs to return a boolean.                                                 
     *                                                                                         
     * @see http://docs.behat.org/cookbook/using_spin_functions.html                            
     *                                                                                         
     * @param \Closure $closure                                                                
     * @param int      $tries                                                                  
     *                                                                                         
     * @return bool                                                                            
     *                                                                                         
     * @throws \Exception|UnsupportedTestException                                             
     * @throws \Exception                                                                      
     */                                                                                        
    public function spin($closure, $tries = 30)                                                
    {                                                                                          
        for ($i = 0; $i < $tries; $i++) {                                                      
            try {                                                                              
                if ($result = $closure($this)) {                                               
                    if (!is_bool($result)) {                                                   
                        throw new UnsupportedTestException(
                            'The spinned callback needs to return true on success or throw an Exception'
                        );
                    }                                                                          
                                                                                               
                    return true;                                                               
                }                                                                              
            } catch (UnsupportedTestException $e) {                                            
                // If the test is unsupported, we quit                                         
                throw $e;                                                                      
            } catch (\Exception $e) {                                                          
                // do nothing to continue the loop                                             
            }                                                                                  
                                                                                               
            usleep(300000);                                                                    
        }                                                                                      
                                                                                               
        $backtrace = debug_backtrace();                                                        
        throw new \Exception(                                                                  
            "Timeout thrown by " . $backtrace[1]['class'] . "::" . $backtrace[1]['function'] . "()\n" .
            "With the following arguments: " . print_r($backtrace[1]['args'], true)
        );
    }
}