<?php
/**
 * Created by IntelliJ IDEA.
 * User: rek
 * Date: 2017/3/17
 * Time: PM8:04
 */

namespace x2lib\JPush;


use x2lib\JPush\notification\Notification;
use x2ts\Component;
use x2ts\ComponentFactory as X;
use x2ts\ComponentNotFoundException;
use x2ts\curl\CURL;

/**
 * Class JPush
 *
 * @property-read CURL $curl
 *
 * @package x2lib
 */
class JPush extends Component {
    protected static $_conf = [
        'api'    => 'https://api.jpush.cn/v3/',
        'appKey' => '',
        'secret' => '',
        'prefix' => '',
        'curlId' => 'curl',
    ];

    /**
     * @var CURL
     */
    private $_curl;

    public function getCurl() {
        if (!$this->_curl instanceof CURL) {
            try {
                $this->_curl = X::getComponent($this->conf['curlId']);
            } catch (ComponentNotFoundException $ex) {
                $this->_curl = X::getInstance(CURL::class, [], [], 'jpush_curl');
            }
        }
        return $this->_curl;
    }

    public function notifyTags(array $tags, Notification $notification, array $options = []) {
        $data = [
            'platform'     => 'all',
            'audience'     => [
                'tag' => array_map(function ($tag) {
                    return $this->conf['prefix'] . $tag;
                }, $tags),
            ],
            'notification' => $notification->notification(),
            'options'      => $options,
        ];

        return $this->push($data);
    }

    public function notifyAlias(array $alias, Notification $notification, array $options = []) {
        $data = [
            'platform'     => 'all',
            'audience'     => [
                'alias' => array_map(function ($alia) {
                    return $this->conf['prefix'] . $alia;
                }, $alias),
            ],
            'notification' => $notification->notification(),
            'options'      => $options,
        ];

        return $this->push($data);
    }

    public function push(array $data) {
        if (!isset($data['options']['apns_production'])) {
            $data['options']['apns_production'] = X_ENV !== 'debug';
        }
        $json = json_encode($data);
        X::logger()->trace('Push body: ' . $json);

        $ret = $this->curl->post(
            $this->conf['api'] . 'push',
            $json,
            [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Basic ' .
                    base64_encode("{$this->conf['appKey']}:{$this->conf['secret']}"),
            ]
        );
        return $ret;
    }
}