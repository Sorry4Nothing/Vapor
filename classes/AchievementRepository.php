<?php
require_once(__DIR__ . "/DbConnHandler.php");
require_once(__DIR__ . "/Repository.php");
require_once(__DIR__ . "/../models/Achievement.class.php");

class AchievementRepository implements RepositoryInterface
{
    public $db;

    public function __construct()
    {
        $this->db = DbConnHandler::getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM achievement_tbl";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $achievements = [];
        foreach ($result as $row) {
            $achievement = new Achievement($row["Id"], $row["name"], $row["description"], $row["isDisabled"], $row["thumbnail"], $row["game_Id"]);
            $achievements[] = $achievement;
        }
        return $achievements;
    }

    public function getAllAchievementsOfGame($gameId): array
    {
        $sql = "SELECT * FROM achievement_tbl WHERE game_Id = :gameId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":gameId", $gameId);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $achievements = [];
        foreach ($result as $row) {
            $achievement = new Achievement($row["Id"], $row["name"], $row["description"], $row["isDisabled"], $row["thumbnail"], $row["game_Id"]);
            $achievements[] = $achievement;
        }
        return $achievements;
    }

    public function getById($achievementId)
    {
        $sql = "SELECT * FROM achievement_tbl WHERE Id = :achievementId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":achievementId", $achievementId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $achievement = new Achievement($result["Id"], $result["name"], $result["description"], $result["isDisabled"], $result["thumbnail"], $result["game_Id"]);

        return $achievement;
    }

    public function add($achievement)
    {
        $sql = "INSERT INTO achievement_tbl (name, description, thumbnail, game_Id, isDisabled) VALUES(:achievementName, :description, :thumbnail, :gameId, 0)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":achievementName", $achievement->achievementName);
        $stmt->bindValue(":description", $achievement->description);
        $stmt->bindValue(":thumbnail", $achievement->thumbnail);
        $stmt->bindValue(":gameId", $achievement->gameId);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function update($achievement)
    {
        $sql = "UPDATE achievement_tbl SET name = :achievementName, description = :description, thumbnail = :thumbnail, game_Id = :gameId, isDisabled = :isDisabled WHERE Id = :achievementId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":achievementName", $achievement->achievementName);
        $stmt->bindValue(":description", $achievement->description);
        $stmt->bindValue(":thumbnail", $achievement->thumbnail);
        $stmt->bindValue(":gameId", $achievement->gameId);
        $stmt->bindValue(":achievementId", $achievement->achievementId);
        $stmt->bindValue(":isDisabled", $achievement->isDisabled);

        try {
            $stmt->execute();
        } catch (Exception $e) {
            echo $e;
        }
    }
}
