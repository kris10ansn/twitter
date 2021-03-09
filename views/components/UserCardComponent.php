<?php


namespace app\views\components;


use app\models\UserModel;
use app\src\Session;
use app\src\util\Text;
use app\src\util\Time;

class UserCardComponent
{
    private UserModel $user;

    public function __construct(UserModel $user)
    {
        $this->user = $user;
    }

    public function __toString(): string
    {
        $me = Session::getUser();

        $biography = Text::render($this->user->biography);

        $follows = $me !== null && $me->follows($this->user->id);
        $followsClass = $follows ? "follows" : "";
        $followButtonText = $follows ? "Unfollow" : "Follow";

        $timeSinceCreation = Time::since(strtotime($this->user->created_at));

        return "
            <div class='card user'>
                <div class='top'>
                    <div class='user-info'>
                        <p>
                            <b>{$this->user->firstname} {$this->user->lastname}</b>
                            (<a href='user/{$this->user->id}'>@{$this->user->username}</a>)
                        </p>
                        <small>
                            <b>{$this->user->followerCount()}</b>
                            <a href='user/{$this->user->id}/followers'>followers</a>
                            <b>{$this->user->followsCount()}</b>
                            <a href='user/{$this->user->id}/following'>following</a>
                            <span class='gray'>Joined {$timeSinceCreation}</span>
                        </small>
                    </div>
                    <form action='user/{$this->user->id}/follow' method='post'>
                        <button class='{$followsClass}'>
                            {$followButtonText}
                        </button>
                    </form>
                </div>
                <div class='biography'>
                    <p>{$biography}</p>
                </div>
            </div>";
    }
}
?>
<link rel="stylesheet" href="styles/components/user.css">

