<?php


namespace Meetanshi\TapFiliate\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Sales\Model\Order;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
class Data extends AbstractHelper
{

    const XML_PATH_TAPFILIATE_ENABLE  = 'tapfiliate/config/enable';
    const XML_PATH_TAPFILIATE_ACCOUNT  = 'tapfiliate/config/account';

    protected $storeManager;
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager
    )
    {
        $this->storeManager = $storeManager;
        parent::__construct($context);
    }

    public function isAllowedTapFiliate(Order $order, $store = null)
    {
        if ( $store === null ) {
            $store = $order->getStoreId();
        }
        $tapFiliate = $this->scopeConfig->isSetFlag(
            self::XML_PATH_TAPFILIATE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $store
        );

        if ( $tapFiliate == true ) {
            $tapFiliateData = array();
            $tapFiliateAccount = $this->scopeConfig->getValue(
                self::XML_PATH_TAPFILIATE_ACCOUNT,
                ScopeInterface::SCOPE_STORE,
                $store
            );
            $tapFiliateData['order'] = $order->getIncrementId();
            $tapFiliateData['amount'] = $order->getGrandTotal();
            $tapFiliateData['account'] = $tapFiliateAccount;
            return $tapFiliateData;
        }
        else{
            return $tapFiliate;
        }


    }
    public function isAllowedBodyTapFiliate($store = null)
    {
        if ( $store === null ) {
            $store = $this->storeManager->getStore();
        }
        $tapFiliateData = array();
        $tapFiliate = $this->scopeConfig->isSetFlag(
            self::XML_PATH_TAPFILIATE_ENABLE,
            ScopeInterface::SCOPE_STORE,
            $store
        );

        if ( $tapFiliate == true ) {
            $tapFiliateAccount = $this->scopeConfig->getValue(
                self::XML_PATH_TAPFILIATE_ACCOUNT,
                ScopeInterface::SCOPE_STORE,
                $store
            );
            $tapFiliateData['account'] = $tapFiliateAccount;
            return $tapFiliateData;
        }
        else{
            return $tapFiliate;
        }


    }

}