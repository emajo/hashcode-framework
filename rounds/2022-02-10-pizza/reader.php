<?php

global $fileName;
/** @var Client[] */
global $clients;
/** @var Ingredient[] */
global $ingredients;

use Utils\FileManager;

require_once '../../bootstrap.php';

class Client
{
    public int $id;
    public array $likes = [];
    /** @var string[] */
    public array $likesAsString = [];
    public array $dislikes = [];
    /** @var string[] */
    public array $dislikesAsString = [];

    public function __toString()
    {
        return 'C#' . $this->id . ' L(' . count($this->likes) . ')'  . 'D(' . count($this->dislikes) . ')';
    }
}

class Ingredient
{
    public string $name;
    /** @var Client[] */
    public array $likedBy = [];
    /** @var Client[] */
    public array $dislikedBy = [];

    public function __toString()
    {
        return $this->name . ' L(' . count($this->likedBy) . ')'  . 'D(' . count($this->dislikedBy) . ')';
    }
}

/**
 * @param string[] $ing
 * @return Ingredient[]
 */
function getIngredients(array $ing): array
{
    global $ingredients;
    $result = [];
    foreach ($ing as $name) {
        if (!isset($ingredients[$name])) {
            $ing = new Ingredient();
            $ing->name = $name;
            $ingredients[$name] = $ing;
        }
        $result[] = $ingredients[$name];
    }
    return $result;
}

// Reading the inputs
$fileManager = new FileManager($fileName);
$content = explode("\n", $fileManager->get());

/** @var int */
$clientsNumber = (int)$content[0];

for ($r = 0; $r < $clientsNumber; $r++) {

    $p = new Client();
    $p->id = $r;

    $ing = explode(' ', $content[$r * 2 + 1]);
    unset($ing[0]);
    $p->likes = getIngredients($ing);
    $p->likesAsString = array_map(fn($i) => $i->name, $p->likes);
    foreach ($p->likes as $like) {
        $like->likedBy[] = $p;
    }

    $ing = explode(' ', $content[$r * 2 + 2]);
    unset($ing[0]);
    $p->dislikes = getIngredients($ing);
    $p->dislikesAsString = array_map(fn($i) => $i->name, $p->dislikes);
    foreach ($p->dislikes as $dislike) {
        $dislike->dislikedBy[] = $p;
    }

    $clients[] = $p;
}

function getIngredientsName($ings)
{
    return array_map(function ($i) {
        return $i->name;
    }, $ings);
}

function getScoreByIngredients($ings)
{
    global $clients;
    $score = 0;

    $ingsString = getIngredientsName($ings);

    foreach ($clients as $client) {
        foreach ($client->likesAsString as $like) {
            if (!in_array($like, $ingsString)) {
                continue 2;
            }
        }
        foreach ($client->dislikesAsString as $dislike) {
            if (in_array($dislike, $ingsString)) {
                continue 2;
            }
        }
        $score++;
    }

    return $score;
}

function recalculateLikesAndDislikes()
{
    /** @var Client[] $clients */
    global $clients;
    /** @var Ingredient[] $ingredients */
    global $ingredients;
    foreach ($ingredients as $i) {
        $i->likedBy = [];
        $i->dislikedBy = [];
    }
    foreach ($clients as $c) {
        foreach ($c->likes as $i) {
            $i->likedBy[] = $c;
        }
        foreach ($c->dislikes as $i) {
            $i->dislikedBy[] = $c;
        }
    }
}

