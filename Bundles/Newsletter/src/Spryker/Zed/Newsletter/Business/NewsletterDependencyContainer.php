<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Newsletter\Business;

use Spryker\Zed\Newsletter\Business\Subscription\SubscriberKeyGenerator;
use Spryker\Zed\Newsletter\Business\Subscription\DoubleOptInHandler;
use Spryker\Zed\Newsletter\Business\Subscription\SingleOptInHandler;
use Spryker\Zed\Newsletter\Business\Subscription\SubscriberManager;
use Spryker\Zed\Newsletter\Business\Subscription\SubscriptionManager;
use Spryker\Zed\Newsletter\Business\Subscription\DoubleOptInHandlerInterface;
use Spryker\Zed\Newsletter\Business\Subscription\SubscriberKeyGeneratorInterface;
use Spryker\Zed\Newsletter\Business\Subscription\SubscriberManagerInterface;
use Spryker\Zed\Newsletter\Business\Subscription\SubscriberOptInHandlerInterface;
use Spryker\Zed\Newsletter\Business\Subscription\SubscriptionManagerInterface;
use Spryker\Zed\Newsletter\Business\Subscription\SubscriptionRequestHandler;
use Spryker\Zed\Newsletter\NewsletterConfig;
use Spryker\Zed\Newsletter\NewsletterDependencyProvider;
use Spryker\Zed\Newsletter\Persistence\NewsletterQueryContainer;
use Spryker\Zed\Kernel\Business\AbstractBusinessDependencyContainer;

/**
 * @method NewsletterConfig getConfig()
 * @method NewsletterQueryContainer getQueryContainer()
 */
class NewsletterDependencyContainer extends AbstractBusinessDependencyContainer
{

    /**
     * @return SubscriptionRequestHandler
     */
    public function createSubscriptionRequestHandler()
    {
        return new SubscriptionRequestHandler(
            $this->createSubscriptionManager(),
            $this->createSubscriberManager(),
            $this->getQueryContainer()
        );
    }

    /**
     * @return SubscriptionManagerInterface
     */
    protected function createSubscriptionManager()
    {
        return new SubscriptionManager(
            $this->getQueryContainer()
        );
    }

    /**
     * @return SubscriberManagerInterface
     */
    protected function createSubscriberManager()
    {
        return new SubscriberManager(
            $this->getQueryContainer(),
            $this->createSubscriberKeyGenerator()
        );
    }

    /**
     * @return SubscriberOptInHandlerInterface
     */
    public function createSingleOptInHandler()
    {
        return new SingleOptInHandler(
            $this->getQueryContainer(),
            $this->createSubscriberKeyGenerator()
        );
    }

    /**
     * @return SubscriberOptInHandlerInterface|DoubleOptInHandlerInterface
     */
    public function createDoubleOptInHandler()
    {
        $subscriberOptInHandler = new DoubleOptInHandler(
            $this->getQueryContainer(),
            $this->createSubscriberKeyGenerator()
        );

        $optInSenderPlugins = $this->getProvidedDependency(NewsletterDependencyProvider::DOUBLE_OPT_IN_SENDER_PLUGINS);

        foreach ($optInSenderPlugins as $optInSenderPlugin) {
            $subscriberOptInHandler->addSubscriberOptInSender($optInSenderPlugin);
        }

        return $subscriberOptInHandler;
    }

    /**
     * @return SubscriberKeyGeneratorInterface
     */
    protected function createSubscriberKeyGenerator()
    {
        return new SubscriberKeyGenerator();
    }

}