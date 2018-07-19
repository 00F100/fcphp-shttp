<?php

namespace FcPhp\SHttp\Interfaces
{
    use FcPhp\Session\Interfaces\ISession;
    use FcPhp\SHttp\Interfaces\ISHttp;
    use FcPhp\SHttp\Interfaces\ISEntity;

    interface ISHttp
    {
        /**
         * Method to construct instance of Security HTTP
         *
         * @param array $post $_POST params
         * @param array $server $_SERVER params
         * @param FcPhp\SHttp\Interfaces\ISEntity $entity Instance of SEntity
         * @param FcPhp\Session\Interfaces\ISession $session Instance of Session
         * @return void
         */
        public function __construct(array $post, array $server, ISEntity $entity, ISession $session = null);

        /**
         * Method to get SEntity of user
         *
         * @return FcPhp\SHttp\Interfaces\ISEntity
         */
        public function get() :ISEntity;

        /**
         * Method to configure callback auth
         *
         * @param string $key Key of callback
         * @param mixed $clousure Clousure to run
         * @return FcPhp\SHttp\Interfaces\ISHttp
         */
        public function callback(string $key, $clousure) :ISHttp;
    }
}