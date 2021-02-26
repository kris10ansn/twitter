<?php


namespace app\models\form;


use app\models\DBModel;
use app\models\UserModel;
use app\src\Database;
use app\src\Session;
use app\src\util\Text;
use app\src\validation\MaximumLengthRule;
use app\src\validation\MinimumLengthRule;
use app\src\validation\RequiredRule;

class PostFormModel extends FormModel
{
    use DBModel;

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

        $this->fields["text"] = Text::process($this->fields["text"]);

        $result = $this->insert("post");

        preg_match_all(Text::HASHTAG_REGEX, $this->fields["text"], $matches);

        if ($result === true && $matches && count($matches[0]) > 0) {
            $db = Database::getInstance();
            $post_id = $db->pdo->lastInsertId();

            foreach ($matches[1] as $hashtag) {
                $hashtag = strtolower($hashtag);

                // IGNORE gjør at om det allerede finnes en rad med like primary keys (f.eks.
                // hvis du har to like hashtags i en post) vil den bare ignoreres
                $statement = $db->pdo->prepare(
                    "INSERT IGNORE INTO hashtagged (post_id, name) VALUES (:post_id, :name)"
                );

                $statement->execute([":post_id" => $post_id, ":name" => $hashtag]);
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