<?php

class Wpopalipay_Payment_Model_Wpopalipay extends Mage_Payment_Model_Method_Abstract {
    protected $_code          = 'wpopalipay';
    protected $_formBlockType = 'wpopalipay/form';
    protected $_infoBlockType = 'wpopalipay/info';
    protected $_order;

    /**
     * Get order model
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if (!$this->_order) {
            $this->_order = $this->getInfoInstance()->getOrder();
        }
        return $this->_order;
    }

    public function getCheckout() {
        return Mage::getSingleton('checkout/session');
    }

    public function getOrderPlaceRedirectUrl() {
        return Mage::getUrl('wpopalipay/redirect', array('_secure' => true));
    }

    /**
     * Method that will be executed instead of authorize or capture
     * if flag isInitializeNeeded set to true
     *
     * @param string $paymentAction
     * @param Mage_Sales_Model_Order $stateObject
     *
     * @return Mage_Payment_Model_Abstract
     */
    public function initialize($paymentAction, $stateObject)
    {
        $state = Mage_Sales_Model_Order::STATE_PENDING_PAYMENT;
        $stateObject->setState($state);
        $stateObject->setStatus($state);
        $stateObject->setIsNotified(false);
    }
}
