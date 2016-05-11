<?php
namespace Omnipay\Braintree\Message;

/**
 * Purchase Request
 *
 * Because a purchase request in Braintree looks similar to an
 * Authorize request, this class simply extends the AuthorizeRequest
 * class and overrides the getData method setting submitForSettlement = true.
 *
 * *Example:*
 *
 * <code>
 * // Create a gateway for the Braintree Gateway
 * // (routes to GatewayFactory::create)
 * $gateway = Omnipay::create('Braintree');
 *
 * // Initialise the gateway
 * $gateway->initialize(array(
 *     'testMode' => true,
 *     'merchantId' => 'use_your_merchant_id',
 *     'publicKey' => 'use_your_public_key',
 *     'privateKey' => 'use_your_private_key'
 * ));
 *
 * // Create a credit card object
 * // This card can be used for testing.
 * $card = new CreditCard(array(
 *     'firstName' => 'Example',
 *     'lastName' => 'Customer',
 *     'number' => '4242424242424242',
 *     'expiryMonth' => '01',
 *     'expiryYear' => '2020',
 *     'cvv' => '123',
 * ));
 *
 * // Do a purchase transaction on the gateway
 * $transaction = $gateway->purchase(array(
 *     'amount' => '10.00',
 *     'card' => $card,
 * ));
 *
 * $response = $transaction->send();
 *
 * if ($response->isSuccessful()) {
 *     echo "Purchase transaction was successful!\n";
 *     $sale_id = $response->getTransactionReference();
 *     echo "Transaction reference = " . $sale_id . "\n";
 * }
 * </code>
 *
 * @method Response send()
 */
class PurchaseRequest extends AuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();

        $data['options']['submitForSettlement'] = true;

        return $data;
    }
}
