<?php

namespace Omnipay\Braintree\Message;

/**
 * CustomerResponse
 */
class CustomerResponse extends Response
{
    public function getCustomerData()
    {
        if (isset($this->data->customer)) {
            return $this->data->customer;
        }

        return null;
    }

    /**
     * Get customer reference (ID).
     *
     * @return string Customer reference
     */
    public function getCustomerReference()
    {
        return $this->data->customer->id;
    }
}
