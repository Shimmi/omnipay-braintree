<?php
namespace Omnipay\Braintree\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;

/**
 * Authorize Request
 *
 * @method Response send()
 * @see https://developers.braintreepayments.com/reference/request/transaction/sale/php
 */
class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount');

        $data = array(
            'amount' => $this->getAmount(),
            'billingAddressId' => $this->getBillingAddressId(),
            'channel' => $this->getChannel(),
            'customFields' => $this->getCustomFields(),
            'customerId' => $this->getCustomerId(),
            'descriptor' => $this->getDescriptor(),
            'deviceData' => $this->getDeviceData(),
            'deviceSessionId' => $this->getDeviceSessionId(),
            'merchantAccountId' => $this->getMerchantAccountId(),
            'orderId' => $this->getTransactionId(),
            'purchaseOrderNumber' => $this->getPurchaseOrderNumber(),
            'recurring' => $this->getRecurring(),
            'serviceFeeAmount' => $this->getServiceFeeAmount(),
            'shippingAddressId' => $this->getShippingAddressId(),
            'taxAmount' => $this->getTaxAmount(),
            'taxExempt' => $this->getTaxExempt(),
            'billingAddress' => $this->getCardBillingAddress(),
        );

        // special validation
        if ($this->getPaymentMethodToken()) {
            $data['paymentMethodToken'] = $this->getPaymentMethodToken();
        } elseif($this->getToken()) {
            $data['paymentMethodNonce'] = $this->getToken();
        } elseif($this->getCard()) {
            $data['creditCard'] = $this->getCardData();
        } else {
            throw new InvalidRequestException('The token (payment nonce), paymentMethodToken or card field should be set.');
        }

        // Remove null values
        $data = array_filter($data, function($value){
            return ! is_null($value);
        });

        $data += $this->getOptionData();
        $data['options']['submitForSettlement'] = false;

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $response = $this->braintree->transaction()->sale($data);

        return $this->createResponse($response);
    }
}
