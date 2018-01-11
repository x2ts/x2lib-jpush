<?php
/**
 * Created by IntelliJ IDEA.
 * User: rek
 * Date: 2017/3/17
 * Time: PM9:24
 */

namespace x2lib\JPush\notification;


class iOS extends Notification {
    public function __construct(Notification $root = null) {
        parent::__construct($root);
        $this->notification = [
            'alert'             => null,
            'sound'             => null,
            'badge'             => null,
            'content-available' => null,
            'mutable-content'   => null,
            'category'          => null,
            'extras'            => null,
        ];
    }

    /**
     * @param string $alert 通知内容
     *
     * 内容为空则不展示到通知栏。
     *
     * @return $this
     */
    public function alert($alert) {
        $this->notification['alert'] = $alert;
        return $this;
    }

    /**
     * @param string $sound 通知提示声音
     *
     * 如果无此字段，则此消息无声音提示；有此字段，如果找到了指定的声音就播放该声音，否则播放默认声音
     * 如果此字段为空字符串，iOS 7 为默认声音，iOS 8及以上系统为无声音。(消息) 说明：JPush 官方 API Library (SDK) 会默认填充声音字段。提供另外的方法关闭声音。
     *
     * @return $this
     */
    public function sound(string $sound) {
        $this->notification['sound'] = $sound;
        return $this;
    }

    /**
     * @param int $badge 应用角标
     *
     * 如果不填，表示不改变角标数字；否则把角标数字改为指定的数字；
     * 为 0 表示清除。JPush 官方 API Library(SDK) 会默认填充badge值为"+1"
     *
     * @return $this
     */
    public function badge(int $badge) {
        $this->notification['badge'] = $badge;
        return $this;
    }

    /**
     * @param bool $content_available 推送唤醒
     *
     * 推送的时候携带"content-available":true 说明是 Background Remote Notification，
     * 如果不携带此字段则是普通的Remote Notification。详情参考：Background Remote Notification
     *
     * @see http://docs.jiguang.cn/jpush/client/iOS/ios_new_fetures/#ios-7-background-remote-notification
     *
     * @return $this
     */
    public function content_available(bool $content_available) {
        $this->notification['content-available'] = $content_available;
        return $this;
    }

    /**
     * @param bool $mutable_content 通知扩展
     *
     * 推送的时候携带”mutable-content":true 说明是支持iOS10的UNNotificationServiceExtension，
     * 如果不携带此字段则是普通的Remote Notification。详情参考：UNNotificationServiceExtension
     *
     * @return $this
     */
    public function mutable_content(bool $mutable_content) {
        $this->notification['mutable-content'] = $mutable_content;
        return $this;
    }

    /**
     * @param array $extras 消息扩展字段
     *
     * @return $this
     */
    public function extras(array $extras) {
        $this->notification['extras'] = $extras;
        return $this;
    }
}