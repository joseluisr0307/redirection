<?php


namespace Dnetix\Redirection\Entities;


use Dnetix\Redirection\Contracts\Entity;
use Dnetix\Redirection\Traits\FieldsTrait;
use Dnetix\Redirection\Traits\LoaderTrait;

class Payment extends Entity
{
    use FieldsTrait, LoaderTrait;

    protected $reference;
    protected $description;
    /**
     * @var Amount
     */
    protected $amount;
    protected $allowPartial = false;
    /**
     * @var Person
     */
    protected $shipping;
    protected $items;
    /**
     * @var Recurring
     */
    protected $recurring;
    /**
     * @var Instrument
     */
    protected $instrument;

    public function __construct($data = [])
    {
        $this->load($data, ['reference', 'description', 'allowPartial', 'items']);

        if (isset($data['amount'])) {
            $this->setAmount($data['amount']);
        }
        if (isset($data['recurring'])) {
            $this->setRecurring($data['recurring']);
        }
        if (isset($data['shipping'])) {
            $this->setShipping($data['shipping']);
        }
        if (isset($data['instrument'])) {
            $this->setInstrument($data['instrument']);
        }
        if (isset($data['fields'])) {
            $this->setFields($data['fields']);
        }
    }

    public function reference()
    {
        return $this->reference;
    }

    public function description()
    {
        return $this->description;
    }

    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return bool
     */
    public function allowPartial()
    {
        return filter_var($this->allowPartial, FILTER_VALIDATE_BOOLEAN);
    }

    public function shipping()
    {
        return $this->shipping;
    }

    public function items()
    {
        return $this->items;
    }

    public function recurring()
    {
        return $this->recurring;
    }

    public function instrument()
    {
        return $this->instrument;
    }

    public function setAmount($amount)
    {
        if (is_array($amount))
            $amount = new Amount($amount);
        $this->amount = $amount;
        return $this;
    }

    public function setRecurring($recurring)
    {
        if (is_array($recurring))
            $recurring = new Recurring($recurring);
        $this->recurring = $recurring;
        return $this;
    }

    public function setShipping($shipping)
    {
        if (is_array($shipping))
            $shipping = new Person($shipping);
        $this->shipping = $shipping;
        return $this;
    }

    public function setInstrument($instrument)
    {
        if (is_array($instrument))
            $instrument = new Instrument($instrument);
        $this->instrument = $instrument;
        return $this;
    }

    public function toArray()
    {
        return array_filter([
            'reference' => $this->reference(),
            'description' => $this->description(),
            'amount' => $this->amount() ? $this->amount()->toArray() : null,
            'allowPartial' => $this->allowPartial,
            'shipping' => $this->shipping() ? $this->shipping()->toArray() : null,
            'items' => $this->items(),
            'recurring' => $this->recurring() ? $this->recurring()->toArray() : null,
            'instrument' => $this->instrument() ? $this->instrument()->toArray() : null,
            'fields' => $this->fieldsToArray()
        ]);
    }

}