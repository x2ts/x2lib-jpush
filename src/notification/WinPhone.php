<?php
/**
 * Created by IntelliJ IDEA.
 * User: rek
 * Date: 2017/3/18
 * Time: PM12:45
 */

namespace x2lib\JPush\notification;


class WinPhone extends Notification {
    public function __construct(Notification $root = null) {
        parent::__construct($root);
        $this->notification = [
            'alert'      => null,
            'title'      => null,
            '_open_page' => null,
            'extras'     => null,
        ];
    }

    /**
     * @param string $alert 通知内容
     *
     * 会填充到 toast 类型 text2 字段上。这里指定了，将会覆盖上级统一指定的 alert 信息；
     * 内容为空则不展示到通知栏。
     *
     * @return $this
     */
    public function alert(string $alert) {
        $this->notification['alert'] = $alert;
        return $this;
    }

    /**
     * @param string $title 通知标题
     *
     * 会填充到 toast 类型 text1 字段上。
     *
     * @return $this
     */
    public function title(string $title) {
        $this->notification['title'] = $title;
        return $this;
    }

    /**
     * @param string $open_page 点击打开的页面名称
     *
     * 点击打开的页面。会填充到推送信息的 param 字段上，表示由哪个 App 页面打开该通知。
     * 可不填，则由默认的首页打开。
     *
     * @return $this
     */
    public function open_page(string $open_page) {
        $this->notification['_open_page'] = $open_page;
        return $this;
    }

    /**
     * @param array $extras 扩展字段
     *
     * 作为参数附加到上述打开页面的后边。
     *
     * @return $this
     */
    public function extras(array $extras) {
        $this->notification['extras'] = $extras;
        return $this;
    }
}