<?php
/**
 * Created by IntelliJ IDEA.
 * User: rek
 * Date: 2017/3/18
 * Time: PM12:20
 */

namespace x2lib\JPush\notification;


use JsonSerializable;

class Notification implements JsonSerializable {
    protected $notification = [
        'alert'    => null,
        'android'  => null,
        'ios'      => null,
        'winphone' => null,
    ];

    protected $root;

    public function __construct(Notification $root = null) {
        $this->root = $root;
        if (null === $root) {
            $this->root = $this;
        }
    }

    /**
     * @param string $alert 通知的内容在各个平台上，都可能只有这一个最基本的属性 "alert"。
     *
     * 这个位置的 "alert" 属性（直接在 notification 对象下），是一个快捷定义，各平台的 alert 信息
     * 如果都一样，则可不定义。如果各平台有定义，则覆盖这里的定义。
     *
     * @return $this
     */
    public function alert($alert) {
        $this->notification['alert'] = $alert;
        return $this;
    }

    public function android(): Android {
        if ($this->root === $this) {
            if (!$this->notification['android'] instanceof Android) {
                $this->notification['android'] = new Android($this);
            }
            return $this->notification['android'];
        } else {
            return $this->root->android();
        }
    }

    public function iOS(): iOS {
        if ($this->root === $this) {
            if (!$this->notification['ios'] instanceof iOS) {
                $this->notification['ios'] = new iOS($this);
            }
            return $this->notification['ios'];
        } else {
            return $this->root->iOS();
        }
    }

    public function winPhone(): WinPhone {
        if ($this->root === $this) {
            if (!$this->notification['winphone'] instanceof WinPhone) {
                $this->notification['winphone'] = new WinPhone($this);
            }
            return $this->notification['winphone'];
        } else {
            return $this->root->winPhone();
        }
    }

    public function notification(): Notification {
        return $this->root;
    }

    public function jsonSerialize() {
        $n = $this->notification;
        foreach ($n as $key => $value) {
            if (null === $value) {
                unset($n[$key]);
            }
        }
        return $n;
    }
}