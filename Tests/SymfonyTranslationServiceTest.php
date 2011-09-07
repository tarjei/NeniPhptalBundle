<?php

/**
 * Test class for SymfonyTranslationService.
 Note: The test does not work atm (missing namespace +)
 */
class SymfonyTranslationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SymfonyTranslationService
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new SymfonyTranslationService;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     */
    public function testSetLanguage()
    {
      $this->object->setLanguage("se_SV");
      $this->assertEquals($this->translator->getLocale(), "se_SV");
    }

    /**
     * @expectedException Exception
     */
    public function testSetEncoding()
    {
      $this->object->setEncoding("ascii");
    }

    /**
     * @todo Implement testUseDomain().
     */
    public function testUseDomain()
    {
      $domain = $this->object->useDomain("txt");
      $this->assertEquals($domain, "txt");
    }

    /**
     * @todo Implement testSetVar().
     */
    public function testSetVar()
    {
      $this->object->setVar("r", "e");
      $this->assertEquals("e", $this->object->getVar("r"));
    }

    /**
     * @todo Implement testTranslate().
     */
    public function testTranslate()
    {
      $key = 'Count: ${count}';
      $this->object->setVar('count', 1);

      $this->assertEquals($this->object->translate($key, false), "Count: 1");
    }
}
?>
