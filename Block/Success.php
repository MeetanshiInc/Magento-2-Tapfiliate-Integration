<?php


namespace Meetanshi\TapFiliate\Block;

use Magento\Checkout\Block\Onepage\Success as CoreSuccess;
use Magento\Framework\View\Element\Template\Context;
use Meetanshi\TapFiliate\Helper\Data;
use Magento\Checkout\Model\Session;
use Magento\Sales\Model\Order\Config;
use Magento\Framework\App\Http\Context as HttpContext;

class Success extends CoreSuccess
{
    private $helper;

    public function __construct(
        Session $checkoutSession,
        Config $orderConfig,
        Context $context,
        HttpContext $httpContext,
        array $data = [],
        Data $helper
    )
    {
        $this->helper = $helper;
        parent::__construct($context, $checkoutSession, $orderConfig, $httpContext, $data);
    }

    /**
     * @return \Magento\Sales\Model\Order
     */

    public function getOrderData()
    {
        $order = $this->_checkoutSession->getLastRealOrder();
        $tapFiliateData = $this->helper->isAllowedTapFiliate($order);
        return $tapFiliateData;

    }
    public function getAccountData()
    {
        $tapFiliateData = $this->helper->isAllowedBodyTapFiliate();
        return $tapFiliateData;

    }

}