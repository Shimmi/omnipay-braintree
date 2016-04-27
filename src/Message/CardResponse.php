<?php

namespace Omnipay\Braintree\Message;

/**
 * CardResponse
 */
class CardResponse extends Response
{
    public function getCardData()
    {
        if (isset($this->data->card)) {
            return $this->data->card;
        }

        return null;
    }

    /**
     * Get a card reference for createCard requests.
     *
     * @return string|null
     */
    public function getCardReference()
    {
        return $this->data->creditCard->token;
    }
}
