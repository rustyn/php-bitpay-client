<?php
/**
 * @license Copyright 2011-2014 BitPay Inc., MIT License
 * see https://github.com/bitpay/php-bitpay-client/blob/master/LICENSE
 */

namespace Bitpay;

/**
 *
 * @package Bitpay
 */
class Invoice implements InvoiceInterface
{
    /**
     * @var CurrencyInterface
     */
    protected $currency;

    /**
     * @var string
     */
    protected $orderId;

    /**
     * @var ItemInterface
     */
    protected $item;

    /**
     * @var string
     */
    protected $transactionSpeed = self::TRANSACTION_SPEED_MEDIUM;

    /**
     * @var string
     */
    protected $notificationEmail;

    /**
     * @var string
     */
    protected $notificationUrl;

    /**
     * @var string
     */
    protected $redirectUrl;

    /**
     * @var string
     */
    protected $posData;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var boolean
     */
    protected $fullNotifications = true;

    /**
     * @var boolean
     */
    protected $extendedNotifications = false;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var \DateTime
     */
    protected $invoiceTime;

    /**
     * @var \DateTime
     */
    protected $expirationTime;

    /**
     * @var DateTime
     */
    protected $currentTime;

    /**
     * @var BuyerInterface
     */
    protected $buyer;

    /**
     * @var
     */
    protected $exceptionStatus;

    
     /**
     * @var
     */
    protected $amountPaid;

    /**
     * @var
     */
    protected $token;

    /**
     * @var array
     */
    protected $refundAddresses;

    /**
     * @var string
     */
    protected $transactionCurrency;

    /**
     * @var array
     */
    protected $exchangeRates;

    /**
     * @var array
     */
    protected $paymentSubtotals;

    /**
     * @var array
     */
    protected $paymentTotals;

    /**
     * @var array
     */
    protected $paymentCurrencies;
    
    /**
     * @inheritdoc
     */
    public function getPrice()
    {
        return $this->getItem()->getPrice();
    }

    /**
     * @param float $price
     *
     * @return InvoiceInterface
     */
    public function setPrice($price)
    {
        if (!empty($price)) {
            $this->getItem()->setPrice($price);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param CurrencyInterface $currency
     *
     * @return InvoiceInterface
     */
    public function setCurrency(CurrencyInterface $currency)
    {
        if (!empty($currency)) {
            $this->currency = $currency;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getItem()
    {
        // If there is not an item already set, we need to use a default item
        // so that some methods do not throw errors about methods and
        // non-objects.
        if (null == $this->item) {
            $this->item = new Item();
        }

        return $this->item;
    }

    /**
     * @param ItemInterface $item
     *
     * @return InvoiceInterface
     */
    public function setItem(ItemInterface $item)
    {
        if (!empty($item)) {
            $this->item = $item;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBuyer()
    {
        // Same logic as getItem method
        if (null == $this->buyer) {
            $this->buyer = new Buyer();
        }

        return $this->buyer;
    }

    /**
     * @param BuyerInterface $buyer
     *
     * @return InvoiceInterface
     */
    public function setBuyer(BuyerInterface $buyer)
    {
        if (!empty($buyer)) {
            $this->buyer = $buyer;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTransactionSpeed()
    {
        return $this->transactionSpeed;
    }

    /**
     * @param string $transactionSpeed
     *
     * @return InvoiceInterface
     */
    public function setTransactionSpeed($transactionSpeed)
    {
        if (!empty($transactionSpeed) && ctype_print($transactionSpeed)) {
            $this->transactionSpeed = trim($transactionSpeed);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getNotificationEmail()
    {
        return $this->notificationEmail;
    }

    /**
     * @param string $notificationEmail
     *
     * @return InvoiceInterface
     */
    public function setNotificationEmail($notificationEmail)
    {
        if (!empty($notificationEmail) && ctype_print($notificationEmail)) {
            $this->notificationEmail = trim($notificationEmail);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getNotificationUrl()
    {
        return $this->notificationUrl;
    }

    /**
     * @param string $notificationUrl
     *
     * @return InvoiceInterface
     */
    public function setNotificationUrl($notificationUrl)
    {
        if (!empty($notificationUrl) && ctype_print($notificationUrl)) {
            $this->notificationUrl = trim($notificationUrl);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @param string $redirectUrl
     *
     * @return InvoiceInterface
     */
    public function setRedirectUrl($redirectUrl)
    {
        if (!empty($redirectUrl) && ctype_print($redirectUrl)) {
            $this->redirectUrl = trim($redirectUrl);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPosData()
    {
        return $this->posData;
    }

    /**
     * @param string $posData
     *
     * @return InvoiceInterface
     */
    public function setPosData($posData)
    {
        if (!empty($posData)) {
            $this->posData = $posData;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return InvoiceInterface
     */
    public function setStatus($status)
    {
        if (!empty($status) && ctype_print($status)) {
            $this->status = trim($status);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isFullNotifications()
    {
        return $this->fullNotifications;
    }

    public function setFullNotifications($notifications)
    {
        $this->fullNotifications = (boolean) $notifications;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function isExtendedNotifications()
    {
        return $this->extendedNotifications;
    }

    public function setExtendedNotifications($notifications)
    {
        $this->extendedNotifications = (boolean) $notifications;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return InvoiceInterface
     */
    public function setId($id)
    {
        if (!empty($id) && ctype_print($id)) {
            $this->id = trim($id);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return InvoiceInterface
     */
    public function setUrl($url)
    {
        if (!empty($url) && ctype_print($url)) {
            $this->url = trim($url);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getInvoiceTime()
    {
        return $this->invoiceTime;
    }

    /**
     * @param DateTime $invoiceTime
     *
     * @return InvoiceInterface
     */
    public function setInvoiceTime($invoiceTime)
    {
        if (is_a($invoiceTime, 'DateTime')) {
            $this->invoiceTime = $invoiceTime;
        } else if (is_numeric($invoiceTime)) {
            $invoiceDateTime = new \DateTime('', new \DateTimeZone("UTC"));
            $invoiceDateTime->setTimestamp($invoiceTime);
            $this->invoiceTime = $invoiceDateTime;
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getExpirationTime()
    {
        return $this->expirationTime;
    }

    /**
     * @param DateTime $expirationTime
     *
     * return InvoiceInterface
     */
    public function setExpirationTime($expirationTime)
    {
        if (is_a($expirationTime, 'DateTime')) {
            $this->expirationTime = $expirationTime;
        } else if (is_numeric($expirationTime)) {
            $expirationDateTime = new \DateTime('', new \DateTimeZone("UTC"));
            $expirationDateTime->setTimestamp($expirationTime);
            $this->expirationTime = $expirationDateTime;
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentTime()
    {
        return $this->currentTime;
    }

    /**
     * @param DateTime $currentTime
     *
     * @return InvoiceInterface
     */
    public function setCurrentTime($currentTime)
    {
        if (is_a($currentTime, 'DateTime')) {
            $this->currentTime = $currentTime;
        } else if (is_numeric($currentTime)) {
            $currentDateTime = new \DateTime('', new \DateTimeZone("UTC"));
            $currentDateTime->setTimestamp($currentTime);
            $this->currentTime = $currentDateTime;
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     *
     * @return InvoiceInterface
     */
    public function setOrderId($orderId)
    {
        if (!empty($orderId) && ctype_print($orderId)) {
            $this->orderId = trim($orderId);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getItemDesc()
    {
        return $this->getItem()->getDescription();
    }

    /**
     * @inheritdoc
     */
    public function getItemCode()
    {
        return $this->getItem()->getCode();
    }

    /**
     * @inheritdoc
     */
    public function isPhysical()
    {
        return $this->getItem()->isPhysical();
    }

    /**
     * @inheritdoc
     */
    public function getBuyerName()
    {
        $firstName = $this->getBuyer()->getFirstName();
        $lastName  = $this->getBuyer()->getLastName();

        return trim($firstName.' '.$lastName);
    }

    /**
     * @inheritdoc
     */
    public function getBuyerAddress1()
    {
        $address = $this->getBuyer()->getAddress();

        return $address[0];
    }

    /**
     * @inheritdoc
     */
    public function getBuyerAddress2()
    {
        $address = $this->getBuyer()->getAddress();

        return $address[1];
    }

    /**
     * @inheritdoc
     */
    public function getBuyerCity()
    {
        return $this->getBuyer()->getCity();
    }

    /**
     * @inheritdoc
     */
    public function getBuyerState()
    {
        return $this->getBuyer()->getState();
    }

    /**
     * @inheritdoc
     */
    public function getBuyerZip()
    {
        return $this->getBuyer()->getZip();
    }

    /**
     * @inheritdoc
     */
    public function getBuyerCountry()
    {
        return $this->getBuyer()->getCountry();
    }

    /**
     * @inheritdoc
     */
    public function getBuyerEmail()
    {
        return $this->getBuyer()->getEmail();
    }

    /**
     * @inheritdoc
     */
    public function getBuyerPhone()
    {
        return $this->getBuyer()->getEmail();
    }

    /**
     * @inheritdoc
     */
    public function getExceptionStatus()
    {
        return $this->exceptionStatus;
    }

    /**
     * @param
     *
     * @return InvoiceInterface
     */
    public function setExceptionStatus($exceptionStatus)
    {
        $this->exceptionStatus = $exceptionStatus;
        return $this;
    }

    /**
     * @param void
     * @return
     */
    public function getAmountPaid()
    {
        return $this->amountPaid;
    }

    /**
     * @param
     * @return Invoice
     */
    public function setAmountPaid($amountPaid)
    {
        if (isset($amountPaid)) {
            $this->amountPaid = $amountPaid;
        }

        return $this;
    }

    /**
     * @param void
     * @return Invoice
     */
    public function getExchangeRates()
    {
        return $this->exchangeRates;
    }

    /**
     * @param
     * @return
     */
    public function setExchangeRates($exchangeRates)
    {
        if (!empty($exchangeRates)) {
            $this->exchangeRates = $exchangeRates;
        }

        return $this;
    }


    /**
     * @return TokenInterface
     */
    public function getToken()
    {
        return $this->token;
    }
    /**
     * @param TokenInterface $token
     * @return InvoiceInterface
     */
    public function setToken(TokenInterface $token)
    {
        $this->token = $token;
        return $this;
    }
    /**
     * @inheritdoc
     */
    public function getRefundAddresses()
    {
        return $this->refundAddresses;
    }

    /**
     * @param array $refundAddress
     *
     * @return InvoiceInterface
     */
    public function setRefundAddresses($refundAddresses)
    {
        if (!empty($refundAddresses)) {
            $this->refundAddresses = $refundAddresses;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTransactionCurrency()
    {
        return $this->transactionCurrency;
    }

    /**
     * @param string $transactionCurrency
     *
     * @return InvoiceInterface
     */
    public function setTransactionCurrency($transactionCurrency)
    {
        if (!empty($transactionCurrency) && ctype_print($transactionCurrency)) {
            $this->transactionCurrency = trim($transactionCurrency);
        }

        return $this;
    }

    /**
     * @param void
     * @return InvoiceInterface
     */
    public function getPaymentSubtotals()
    {
        return $this->paymentSubtotals;
    }

    /**
     * @param 
     * @return InvoiceInterface
     */
    public function setPaymentSubtotals($paymentSubtotals)
    {
        if (!empty($paymentSubtotals)) {
            $this->paymentSubtotals = $paymentSubtotals;
        }

        return $this;
    }
     /**
     * @param void
     * @return InvoiceInterface
     */
    public function getPaymentTotals()
    {
        return $this->paymentTotals;
    }

    /**
     * @param 
     * @return InvoiceInterface
     */
    public function setPaymentTotals($paymentTotals)
    {
        if (!empty($paymentTotals)) {
            $this->paymentTotals = $paymentTotals;
        }

        return $this;
    }
    
     /**
     * @param
     * @return InvoiceInterface
     */
    public function setPaymentCurrencies($paymentCurrencies)
    {
        if (!empty($paymentCurrencies)) {
            $this->paymentCurrencies = $paymentCurrencies;
        }

        return $this;
    }

    /**
     * @param array
     * @return InvoiceInterface
     */
    public function getPaymentCurrencies()
    {
        return $this->paymentCurrencies;
    }
}
