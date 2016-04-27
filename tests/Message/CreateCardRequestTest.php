<?php

namespace Omnipay\Braintree\Message;

use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class CreateCardRequestTest extends TestCase
{
    /**
     * @var CreateCardRequest
     * @see https://developers.braintreepayments.com/reference/general/testing/php
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new CreateCardRequest($this->getHttpClient(), $this->getHttpRequest(), \Braintree_Configuration::gateway());

        $card = new CreditCard();
        $card->setFirstName('Mike')
            ->setLastName('Jones')
            ->setEmail('mike.jones@example.com')
            ->setExpiryMonth('05')
            ->setExpiryYear('19')
            // https://developers.braintreepayments.com/reference/general/testing/php#no-credit-card-errors
            ->setNumber('4111111111111111')
            // https://developers.braintreepayments.com/reference/general/testing/php#avs-and-cvv/cid-responses
            ->setCvv('500');

        $this->request->initialize(
            array(
                'customerReference' => 'XY',
                'card' => $card,
            )
        );
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame('4111111111111111', $data['number']);
        $this->assertSame(5, $data['expirationMonth']);
        $this->assertSame(2019, $data['expirationYear']);
        $this->assertSame('Mike', $data['billingAddress']['firstName']);
        $this->assertSame('Jones', $data['billingAddress']['lastName']);
        $this->assertSame('Mike', $data['billingAddress']['firstName']);
        $this->assertSame('Jones', $data['billingAddress']['lastName']);
    }

    public function testRequestData()
    {
        $this->assertNull($this->request->getCardReference());
        $this->assertSame(
            array (
                'customerId' => 'XY',
                'number' => '4111111111111111',
                'expirationMonth' => 5,
                'expirationYear' => 2019,
                'billingAddress' => array (
                    'company' => null,
                    'firstName' => 'Mike',
                    'lastName' => 'Jones',
                    'streetAddress' => null,
                    'extendedAddress' => null,
                    'locality' => null,
                    'postalCode' => null,
                    'region' => null,
                    'countryName' => null,
                ),
                'cvv' => '500',
            ),
            $this->request->getCardData()
        );
    }
}
