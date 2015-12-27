<?php

/**
 * @copyright (c) owl
 */
namespace Owl\Handlers\Events;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Contracts\Mail\Mailer;
use Owl\Events\Item\CommentEvent;
use Owl\Events\Item\GoodEvent;
use Owl\Events\Item\FavoriteEvent;
use Owl\Repositories\ItemRepositoryInterface as ItemRepository;
use Owl\Repositories\UserRepositoryInterface as UserRepository;

/**
 * Class EmailNotification
 *
 * @package Owl\Handlers\Events
 */
class EmailNotification {

    /** @var Mailer */
    protected $mail;

    /** @var ItemRepository */
    protected $item;

    /** @var UserRepository */
    protected $user;

    /**
     * @param Mailer          $mailer
     * @param ItemRepository  $itemRepository
     * @param UserRepository  $userRepository
     */
    public function __construct(
        Mailer         $mailer,
        ItemRepository $itemRepository,
        UserRepository $userRepository
    ) {
        $this->mail = $mailer;
        $this->item = $itemRepository;
        $this->user = $userRepository;
    }

    /**
     * 記事にコメントがついた時のメール通知
     *
     * @param CommentEvent  $event
     */
    public function onGetComment(CommentEvent $event)
    {
        $item      = $this->item->getByOpenItemId($event->getId());
        $recipient = $this->user->getById($item->user_id);
        $sender    = $this->user->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        }

        $data = [
            'recipient' => $recipient->username,
            'sender'    => $sender->username,
            'itemId'    => $item->open_item_id,
            'itemTitle' => $item->title,
            'comment'   => $event->getComment(),
        ];
        $this->mail->send(
            'emails.action.comment', $data,
            function ($m) use ($recipient, $sender) {
                $m->to($recipient->email)
                    ->subject($sender->username.'さんからコメントがつきました - Owl');
            }
        );
    }

    /**
     * 記事にいいね！がついた時
     *
     * @param GoodEvent  $event
     */
    public function onGetGood(GoodEvent $event)
    {
        $item      = $this->item->getByOpenItemId($event->getId());
        $recipient = $this->user->getById($item->user_id);
        $sender    = $this->user->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        }

        $data = [
            'recipient' => $recipient->username,
            'sender'    => $sender->username,
            'itemId'    => $item->open_item_id,
            'itemTitle' => $item->title,
        ];
        $this->mail->send(
            'emails.action.good', $data,
            function ($m) use ($recipient, $sender) {
                $m->to($recipient->email)
                    ->subject($sender->username.'さんからいいねがつきました - Owl');
            }
        );
    }

    /**
     * 記事がお気に入りされた時
     *
     * @param FavoriteEvent  $event
     */
    public function onGetFavorite(FavoriteEvent $event)
    {
        $item      = $this->item->getByOpenItemId($event->getId());
        $recipient = $this->user->getById($item->user_id);
        $sender    = $this->user->getById($event->getUserId());

        if ($this->areUsersSame($recipient, $sender)) {
            return false;
        }

        $data = [
            'recipient' => $recipient->username,
            'sender'    => $sender->username,
            'itemId'    => $item->open_item_id,
            'itemTitle' => $item->title,
        ];
        $this->mail->send(
            'emails.action.favorite', $data,
            function ($m) use ($recipient, $sender) {
                $m->to($recipient->email)
                    ->subject($sender->username.'さんに記事がお気に入りされました - Owl');
            }
        );
    }

    /**
     * 記事が編集された時
     *
     * @param mixed $event
     */
    public function onItemEdited($event)
    {
        // TODO: 記事編集通知送信
    }

    /**
     * 各イベントにハンドラーメソッドを登録
     *
     * @param \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $subscriberName = '\Owl\Handlers\Events\EmailNotification';

        $events->listen(CommentEvent::class,  $subscriberName.'@onGetComment');
        $events->listen(GoodEvent::class,     $subscriberName.'@onGetGood');
        $events->listen(FavoriteEvent::class, $subscriberName.'@onGetFavorite');
        $events->listen('event.item.edit',    $subscriberName.'@onItemEdited');
    }

    /**
     * 通知を発生させたユーザと通知を受け取るユーザが同じかチェックする
     *
     * @parma object  $recipient
     * @param object  $sender
     *
     * @return bool
     */
    protected function areUsersSame($recipient, $sender)
    {
        return $recipient->id === $sender->id;
    }
}