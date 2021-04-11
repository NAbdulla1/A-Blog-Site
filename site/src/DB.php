<?php

namespace Blog;

use Blog\models\User;
use mysqli;

class DB
{
    private static $conn;

    private final function __construct()
    {
    }

    public static function conn(): mysqli
    {
        if (!isset(self::$conn))
            self::$conn = new mysqli('localhost', 'id16518670_root', '9<!gVi{3m{/otZD=', 'id16518670_new_blog_db');
        return self::$conn;
    }

    public static function isEmailExists($email): bool
    {
        $stmt = self::conn()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public static function encryptPassword($pass)
    {
        return password_hash($pass, PASSWORD_BCRYPT);
    }

    public static function isEmailPasswordCorrect($email, $pass): bool
    {
        if (!self::isEmailExists($email))
            return false;
        $pass_from_db = self::conn()->query("SELECT password from users where email = '$email'")->fetch_assoc()['password'];
        return password_verify($pass, $pass_from_db);
    }

    public static function getUserByEmail($email): User
    {
        $userRes = self::conn()->query("SELECT * from users where email = '$email'")->fetch_assoc();
        return new User($userRes['id'], $userRes['name'], $userRes['email'], $userRes['password'], $userRes['profile_pic_path'], $userRes['is_admin']);
    }

    public static function getUserById($id): ?User
    {
        if (empty($id) || $id == null) return User::nullUser();
        $userRes = self::conn()->query("SELECT * from users where id = $id")->fetch_assoc();
        return new User($userRes['id'], $userRes['name'], $userRes['email'], $userRes['password'], $userRes['profile_pic_path'], $userRes['is_admin']);
    }

    public static function getImages($blogId): array
    {
        $images = [];
        $res = self::conn()->query("SELECT * FROM blog_images where blog_id = $blogId");
        while ($imgPath = $res->fetch_assoc())
            array_push($images, $imgPath['path']);
        return $images;
    }

    public static function get3RandomPost(): array
    {
        $res = self::conn()->query("SELECT * FROM blogs WHERE author_id IS NOT NULL ORDER BY RAND() LIMIT 3;");
        $posts = [];
        while ($pst = $res->fetch_assoc())
            array_push($posts, $pst);
        return $posts;
    }

    public static function getComments($blogID): array
    {
        $res = self::conn()->query("SELECT * FROM comments WHERE blog_id = $blogID;");
        $comments = [];
        if ($res == null) return $comments;
        while ($pst = $res->fetch_assoc())
            array_push($comments, $pst);
        return $comments;
    }

    public static function getTop3PostsByCommentCount(): array
    {
        $query = "SELECT id, title_text, comments_count
                        from blogs
                                 join (SELECT blog_id, count(*) as comments_count FROM comments group by blog_id) as tab
                                      on tab.blog_id = blogs.id
                        order by comments_count desc
                        limit 3;
                        ";
        $res = self::conn()->query($query);
        $posts = [];
        while ($pst = $res->fetch_assoc())
            array_push($posts, $pst);
        return $posts;
    }

    public static function update_name(string $name, string $userId): bool
    {
        $stmt = DB::conn()->prepare("UPDATE users SET name = ? WHERE id = ?");
        $stmt->bind_param("ss", $name, $userId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function update_prof_pic(string $picSavePath, $user_id): bool
    {
        $stmt = DB::conn()->prepare("UPDATE users SET profile_pic_path = ? WHERE id = ?");
        $stmt->bind_param("ss", $picSavePath, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function confirmPassword(string $old_pass, $user_id): bool
    {
        $stmt = DB::conn()->prepare("SELECT password from users WHERE id = ?");
        $stmt->bind_param("s", $user_id);
        $result = $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            $stmt->close();
            return false;
        }
        $result = $result->fetch_assoc()['password'];
        $stmt->close();
        return password_verify($old_pass, $result);
    }

    public static function updatePassword(string $new_pass2, $user_id): bool
    {
        $new_pass2 = self::encryptPassword($new_pass2);
        $stmt = DB::conn()->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("ss", $new_pass2, $user_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function addTag(string $tag): bool
    {
        $stmt = DB::conn()->prepare("INSERT INTO tags(tag_name) VALUES(?)");
        $stmt->bind_param("s", $tag);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function editTag(string $tag, string $etagId)
    {
        $stmt = DB::conn()->prepare("UPDATE tags SET tag_name = ? WHERE id = ?");
        $etagId1 = (int)$etagId;
        $stmt->bind_param("si", $tag, $etagId1);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function addCategory(string $filterInput): bool
    {
        $stmt = DB::conn()->prepare("INSERT INTO categories(category_name) VALUES(?)");
        $stmt->bind_param("s", $filterInput);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function editCategory(string $tag, $etagId)
    {
        $stmt = DB::conn()->prepare("UPDATE categories SET category_name = ? WHERE id = ?");
        $etagId1 = (int)$etagId;
        $stmt->bind_param("si", $tag, $etagId1);
        $result = $stmt->execute();
        $stmt->close();
        MyLogger::dbg($etagId1);
        MyLogger::dbg($result);
        return $result;
    }

    public static function addUser(string $name, string $email, string $pass, bool $isAdmin)
    {
        $profile_pic = "../images/dummy_pic.png";
        $stmt = DB::conn()->prepare("INSERT INTO users(name, email, password, profile_pic_path, is_admin) VALUES(?, ?, ?, ?, ?)");
        $pass = self::encryptPassword($pass);
        $stmt->bind_param("ssssi", $name, $email, $pass, $profile_pic, $isAdmin);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function setAdminStatus($etagId, bool $admin)
    {
        $stmt = DB::conn()->prepare("UPDATE users SET is_admin = ? WHERE id = ?");
        $var1 = (int)$admin;
        $stmt->bind_param("is", $var1, $etagId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function addBlogPost(string $title, string $blogText, string $imageSavePath, string $authorID, string $blogCategoryID, int &$blogID): bool
    {
        $stmt = self::conn()->prepare("INSERT INTO blogs(title_text, title_img_path, blog_text, author_id, category_id) VALUES(?, ?, ?, ?, ?);");
        $stmt->bind_param("sssii", $title, $imageSavePath, $blogText, $authorID, $blogCategoryID);
        $res = $stmt->execute();
        $blogID = $stmt->insert_id;
        $stmt->close();
        return $res;
    }

    public static function getLikeCount($blgId)
    {
        $res = self::conn()->query("SELECT COUNT(*) as likes FROM likes WHERE blog_id = $blgId;");
        if($res==null)return 0;
        return $res->fetch_assoc()['likes'];
    }

    public static function updateBlogPost(string $title, string $blogText, string $imageSavePath, string $blogCategoryID, $blogID)
    {
        $stmt = self::conn()->prepare("UPDATE blogs SET title_text = ?, title_img_path = ?, blog_text = ?, category_id = ? WHERE id = ?;");
        $stmt->bind_param("sssii", $title, $imageSavePath, $blogText, $blogCategoryID, $blogID);
        $res = $stmt->execute();
        $stmt->close();
        return $res;
    }

    public static function getBlogTagIDs($blogID): array
    {
        $tags = [];
        if ($blogID == null) return $tags;
        $res = self::conn()->query("SELECT tags_id FROM blogs_has_tags where blogs_id = $blogID");
        while ($tag = $res->fetch_assoc())
            array_push($tags, $tag['tags_id']);
        return $tags;
    }

    public static function getBlogAuthorId($blog_id)
    {
        return self::conn()->query("SELECT author_id FROM blogs WHERE id = $blog_id")->fetch_assoc()['author_id'];
    }

    public static function editComment(string $filterInput, $selectedCommentID)
    {
        $stmt = DB::conn()->prepare("UPDATE comments SET comment_text = ? WHERE id = ?");
        $etagId1 = (int)$selectedCommentID;
        $stmt->bind_param("si", $filterInput, $etagId1);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function getCategoryById($id)
    {
        if ($id == null) return null;
        return self::conn()->query("SELECT * from categories where id = $id")->fetch_assoc()['category_name'];
    }

    public static function getUserProfilePicPath($author_id)
    {
        return Utils::topLevelImage(self::getUserById($author_id)->profile_pic_path);
    }
}