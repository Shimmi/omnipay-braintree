<?php
namespace Omnipay\Braintree\Message;

/**
 * Authorize Request
 *
 * @method CardResponse send()
 */
class CreateCardRequest extends AbstractRequest
{
    public function getData()
    {
        return $this->getCardData();
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return CardResponse
     */
    public function sendData($data)
    {
        $response = $this->braintree->creditCard()->create($data);

        return $this->response = new CardResponse($this, $response);
    }
}
