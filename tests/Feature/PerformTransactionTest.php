<?php

namespace Feature;

use TestCase;

class PerformTransactionTest extends TestCase
{
    public function testPerformTransactionSuccessful()
    {
        $this->get('/');

        $this->assertEquals(
            $this->app->version(), $this->response->getContent()
        );
    }

    public function testTryPerformTransactionValidationError()
    {
    }

    public function testTryPerformTransactionWithUserError()
    {
    }

    public function testTryPerformTransactionWithInternalServerError()
    {
    }
}
