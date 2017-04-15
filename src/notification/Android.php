<?php

namespace x2lib\JPush\notification;

/**
 * Created by IntelliJ IDEA.
 * User: rek
 * Date: 2017/3/17
 * Time: PM8:17
 */
class Android extends Notification {
    public function __construct(Notification $root = null) {
        parent::__construct($root);
        $this->notification = [
            'alert'        => null,
            'title'        => null,
            'builder_id'   => null,
            'priority'     => 0,
            'category'     => null,
            'style'        => 0,
            'alert_type'   => -1,
            'big_text'     => null,
            'inbox'        => null,
            'big_pic_path' => null,
            'extras'       => null,
        ];
    }

    /**
     * @param string $alert 通知内容：这里指定了，则会覆盖上级统一指定的 alert 信息；内容可以为空字符串，则表示不展示到通知栏。
     *
     * @return $this
     */
    public function alert($alert) {
        $this->notification['alert'] = $alert;
        return $this;
    }

    /**
     * @param string $title 通知标题：如果指定了，则通知里原来展示 App名称的地方，将展示成这个字段。
     *
     * @return $this
     */
    public function title(string $title) {
        $this->notification['title'] = $title;
        return $this;
    }

    /**
     * @param int $builder_id 通知栏样式ID：Android SDK 可设置通知栏样式，这里根据样式 ID 来指定该使用哪套样式。
     *
     * @return $this
     */
    public function builder_id(int $builder_id) {
        $this->notification[$builder_id] = $builder_id;
        return $this;
    }

    /**
     * @param int $priority 通知栏展示优先级：默认为0，范围为 -2～2 ，其他值将会被忽略而采用默认。
     *
     * @return $this
     */
    public function priority(int $priority) {
        $this->notification['priority'] = $priority;
        return $this;
    }

    /**
     * @param string $category 通知栏条目过滤或排序：完全依赖 rom 厂商对 category 的处理策略
     *
     * @return $this
     */
    public function category(string $category) {
        $this->notification['category'] = $category;
        return $this;
    }

    const STY_DEFAULT = 0;
    const STY_BIG_TEXT = 1;
    const STY_INBOX = 2;
    const STY_BIG_PIC = 3;

    /**
     * @param int $style 通知栏样式类型：默认为0，还有1，2，3可选，用来指定选择哪种通知栏样式，可以用STY_BIG_TEXT等常量
     *
     * @return $this
     */
    public function style(int $style) {
        $this->notification['style'] = $style;
        return $this;
    }

    const N_ALL = -1;
    const N_SOUND = 1;
    const N_VIBRATE = 2;
    const N_LIGHT = 4;

    /**
     * @param int $alert_type 通知提醒方式：可选范围为 -1 ～ 7 ，对应N_ALL、N_SOUND、N_VIBRATE、N_LIGHT常量，可以按位或组合
     *
     * @return $this
     */
    public function alert_type(int $alert_type) {
        $this->notification['alert_type'] = $alert_type;
        return $this;
    }

    /**
     * @param string $big_text 大文本通知栏样式，内容会被通知栏以大文本的形式展示出来。支持 api 16以上的rom。
     *
     * @return $this
     * @throws \x2lib\JPush\notification\NotificationException
     */
    public function big_text(string $big_text) {
        if ($this->notification['style'] === Android::STY_DEFAULT) {
            $this->notification['style'] = Android::STY_BIG_TEXT;
        } else {
            throw new NotificationException('Using big_text requires the style to be Notification::STY_BIG_TEXT');
        }
        $this->notification['big_text'] = $big_text;
        return $this;
    }

    /**
     * @param array $inbox 文本条目通知栏样式：数组的每个 key 对应的 value 会被当作文本条目逐条展示。支持 api 16以上的rom。
     *
     * @return $this
     * @throws \x2lib\JPush\notification\NotificationException
     */
    public function inbox(array $inbox) {
        if ($this->notification['style'] === Android::STY_DEFAULT) {
            $this->notification['style'] = Android::STY_INBOX;
        } else {
            throw new NotificationException('Using inbox requires the style to be Notification::STY_INBOX');
        }
        $this->notification['inbox'] = $inbox;
        return $this;
    }

    /**
     * @param string $big_pic_path 大图片通知栏样式：网络图片 url，或本地图片的 path，目前支持.jpg和.png后缀的图片。图片内容会被通知栏以大图片的形式展示出来。如果是 http／https
     *                             的url，会自动下载；如果要指定开发者准备的本地图片就填sdcard 的相对路径。支持 api 16以上的rom。
     *
     * @return $this
     * @throws \x2lib\JPush\notification\NotificationException
     */
    public function big_pic_path(string $big_pic_path) {
        if ($this->notification['style'] === Android::STY_DEFAULT) {
            $this->notification['style'] = Android::STY_BIG_PIC;
        } else {
            throw new NotificationException('Using big_pic_path requires the style to be Notification::STY_BIG_PIC');
        }
        $this->notification['big_pic_path'] = $big_pic_path;
        return $this;
    }

    /**
     * @param array $extras 扩展字段：这里自定义的 Key/Value 信息，以供业务使用。
     *
     * @return $this
     */
    public function extras(array $extras) {
        $this->notification['extras'] = $extras;
        return $this;
    }
}