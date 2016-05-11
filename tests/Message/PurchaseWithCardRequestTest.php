<?php

namespace Omnipay\Braintree\Message;

use Omnipay\Tests\TestCase;

class PurchaseWithCardRequestTest extends TestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest(), \Braintree_Configuration::gateway());
        $this->request->initialize(
            array(
                'amount' => '10.00',
                'testMode' => false,
                'card' => array(
                    'number' => '4111111111111111',
                    'cvv' => '500',
                    'expiryMonth' => '05',
                    'expiryYear' => '19',
                ),
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('4111111111111111', $data['creditCard']['number']);
        $this->assertSame(5, $data['creditCard']['expirationMonth']);
        $this->assertSame(2019, $data['creditCard']['expirationYear']);
        $this->assertSame('500', $data['creditCard']['cvv']);
        $this->assertSame('10.00', $data['amount']);

        $this->assertTrue($data['options']['submitForSettlement']);
    }

}
