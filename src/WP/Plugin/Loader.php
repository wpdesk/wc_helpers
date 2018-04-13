<?php

namespace WPDesk\WP\Plugin;

class Loader
{
    private static $loadables = [];

    /**
     * @param SupportsAutoloading $loadable
     */
    public function register_plugin(SupportsAutoloading $loadable)
    {
        self::$loadables[] = [ 'object' => $loadable, 'loaded' => false ];
    }

    private function sortLoadables()
    {
        usort(self::$loadables, function ($a, $b) {
            /** @var SupportsAutoloading $objectA */
            $objectA = $a['object'];
            /** @var SupportsAutoloading $objectB */
            $objectB = $b['object'];

            return $objectA->get_release_date()->getTimestamp() - $objectB->get_release_date()->getTimestamp();
        });
    }

    public function load_autoloaders()
    {
        $this->sortLoadables();
        foreach (self::$loadables as $loadable) {
            if (!$loadable['loaded']) {
                /** @var SupportsAutoloading $object */
                $object = $loadable['object'];

                /** @var SupportsAutoloading $loadable */
                require_once($object->get_autoload_file());

                $loadable['loaded'] = true;
            }
        }
    }
}