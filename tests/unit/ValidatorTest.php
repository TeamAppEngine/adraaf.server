<?php


class ValidatorTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testEmailValidationMethod()
    {
        $this->assertTrue   (\App\Http\Libraries\InputValidator::IsEmailValid('sadjad@teatalk.io'));
        $this->assertFalse  (\App\Http\Libraries\InputValidator::IsEmailValid('sadjad'));
    }
}