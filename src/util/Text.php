<?php


namespace app\src\util;


use app\models\UserModel;

/**
 * Class Text
 * @package app\src\util
 */
class Text
{
    public const HASHTAG_REGEX = "/\w*(?<!&)#(\w+)/";

    public static function render(string $text): string
    {
        return preg_replace(
            [self::HASHTAG_REGEX, "/@\[(\d+)](\w+)/", "/(https?[\-\w@:%_\+.~#?,&\/\/=]+)/"],
            ['<a href="hashtag/$1">#$1</a>', '<a href="user/$1">@$2</a>', '<a href="$1" target="_blank">$1</a>'],
            $text
        );
    }

    /**
     * @param string $text
     * @return string|string[]
     */
    public static function process(string $text)
    {
        preg_match_all("/@(\w+)/", $text, $matches);

        if (isset($matches[1])) {
            for ($i = 0; $i < count($matches[1]); $i++) {
                $match = $matches[0][$i];
                $username = $matches[1][$i];
                $user = UserModel::find([ "username" => $username ]);

                if ($user) {
                    $text = str_replace($match, "@[{$user->id}]{$username}", $text);
                }
            }
        }

        return $text;
    }
}