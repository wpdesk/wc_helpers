<?php

namespace WPDesk\WC\Helper;

use WPDesk\WC\Helper\Compatibility\HelperFactory;
use WPDesk\WC\Helper\Compatibility\HelperFactoryLegacyV33;
use WPDesk\WC\Helper\Compatibility\HelperFactoryLegacyV27;

class Factory
{
    /**
     * @param $version
     *
     * @return HelperFactory
     */
    public static function create_compatibility_helper_factory($version = WC_VERSION)
    {
        if (version_compare($version, '2.7', '<')) {
            return new HelperFactoryLegacyV27();
        } else {
            return new HelperFactoryLegacyV33();
        }
    }
}