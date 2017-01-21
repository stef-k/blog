<?php

//use Illuminate\Foundation\Testing\WithoutMiddleware;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Foundation\Testing\DatabaseTransactions;

class PublicPagesTest extends TestCase
{
    /**
     * Tests public facing pages against some known content.
     *
     * @return void
     */
    public function testHomePage()
    {
        $this->visit('/')
             ->see('About this site');
    }

    public function testContactPage()
    {
        $this->visit('/contact')
             ->see('Your message');
    }
}
