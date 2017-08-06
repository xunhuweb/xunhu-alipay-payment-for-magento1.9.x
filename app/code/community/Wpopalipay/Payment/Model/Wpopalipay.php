<?php

class Wpopalipay_Payment_Model_Wpopalipay extends Mage_Payment_Model_Method_Abstract {
    protected $_code          = 'wpopalipay';
    protected $_formBlockType = 'wpopalipay/form';
    //protected $_infoBlockType = 'wpopalipay/info';
    protected $_order;

    protected $_isGateway               = false;
    protected $_canAuthorize            = true;
    protected $_canCapture              = true;
    protected $_canVoid                 = false;
    protected $_canUseInternal          = false;
    protected $_canUseCheckout          = true;
    protected $_canUseForMultishipping  = false;
    protected $_canRefund               = false;
    
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
    
    public function capture(Varien_Object $payment, $amount)
    {
        $payment->setStatus(self::STATUS_APPROVED)->setLastTransId($this->getTransactionId());
    
        return $this;
    }
    
    public function getRepayUrl($order){
        return Mage::getUrl('wpopalipay/redirect', array('_secure' => true,'orderId'=>$order->getRealOrderId()));
    }
}
