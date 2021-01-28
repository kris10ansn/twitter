<?php


namespace app\models;


use app\src\Database;
use app\src\Session;
use app\src\validation\MaximumLengthRule;
use app\src\validation\MinimumLengthRule;
use app\src\validation\RequiredRule;

class PostFormModel extends FormModel
{
    use DBModel;

    public const HASHTAG_REGEX = "/\w*(?<!&)#(\w+)/";

    public array $fields = [
        "text" => "",
        "user_id" => "",
    ];

    public function post(): bool
    {
        $user = Session::getUser();
        if (!$user) {
            die("User not found");
        }

        $this->fields["user_id"] = $user->id;


        $result = $this->insert("post");

        preg_match_all(self::HASHTAG_REGEX, $this->fields["text"], $matches);

        if ($result === true && $matches && count($matches[0]) > 0) {
            $db = Database::getInstance();
            $post_id = $db->pdo->lastInsertId();

            foreach ($matches[1] as $hashtag) {
                $hashtag = strtolower($hashtag);

                $statement = $db->pdo->prepare("INSERT INTO hashtagged (post_id, name) VALUES (:post_id, :name)");
                $statement->bindValue(":post_id", $post_id);
                $statement->bindValue(":name", $hashtag);

                $statement->execute();
            }

        }

        return $result;
    }

    protected function rules(): array
    {
        return [
            "text" => [
                new RequiredRule("What do you want to post?"),
                new MaximumLengthRule(
                    255,
                    "Post can't be longer than {max} characters. (You typed {num})"
                ),
            ],
        ];
    }
}