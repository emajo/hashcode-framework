<?php

namespace Solutions\Reply24;

use Solutions\Reply24\Classes\GoldenPoint;
use Solutions\Reply24\Classes\Point;
use Solutions\Reply24\Classes\SilverPoint;
use Solutions\Reply24\Classes\Tile;
use Solutions\Reply24\Classes\TileType;
use Solver\Script;
use Utils\Env;
use Utils\File;

class Reply24Script extends Script
{
    public function __construct(protected Reply24Parameters $params)
    {
    }

    public function run()
    {
        $input = $this->readFile($this->params->filename);
        $parsedInput = $this->parseInput($input);

        $goldenPoints = $parsedInput['goldenPoints'];
        $silverPoints = $parsedInput['silverPoints'];

        foreach ($goldenPoints as $goldenPoint) {
            $nearestSilverPoint = $silverPoints->where('visited', false)->sortBy(function ($silverPoint) use ($goldenPoint) {
                return abs($silverPoint->x - $goldenPoint->x) + abs($silverPoint->y - $goldenPoint->y);
            })->first();
            $goldenPoint->nearestSilverPoint = $nearestSilverPoint;
        }

        $res = $goldenPoints->chunk(2)->map(function ($chunk) use ($parsedInput) {

            $chunk->first()->nearestSilverPoint->visited = true;
            $chunk->last()->nearestSilverPoint->visited = true;

            $pathGold1 = Point::connect($chunk->first(), $chunk->first()->nearestSilverPoint, $parsedInput['tiles']);
            array_pop($pathGold1['path']);
            $pathSilver = Point::connect($chunk->first()->nearestSilverPoint, $chunk->last()->nearestSilverPoint, $parsedInput['tiles'], $pathGold1['lastMovement']);
            array_pop($pathSilver['path']);
            $pathGold2 = Point::connect($chunk->last()->nearestSilverPoint, $chunk->last(), $parsedInput['tiles'], $pathSilver['lastMovement']);
            array_pop($pathGold2['path']);
            // TODO ricordarsi di reinserire la tile
            return array_merge($pathGold1['path'], $pathSilver['path'], $pathGold2['path']);
        })->collapse();

        return join(
            "\n",
            $res->toArray()
        );
    }

    private function parseInput(string $input)
    {
        $rows = collect(explode("\n", $input));
        [$columnsCount, $rowsCount, $goldenPointsCount, $silverPointsCount] = explode(' ', $rows->first());

        $goldenPointPositions = $rows->skip(1)->take((int)$goldenPointsCount);
        $silverPointPositions = $rows->skip((int)$goldenPointsCount + 1,)->take((int)$silverPointsCount);
        $gridPositions = $rows->skip((int)$goldenPointsCount + (int)$silverPointsCount + 1);

        $goldenPoints = $goldenPointPositions->map(function ($position) {
            [$x, $y] = explode(' ', $position);
            return new GoldenPoint((int)$x, (int)$y);
        });

        $silverPoints = $silverPointPositions->map(function ($position) {
            [$x, $y, $cost] = explode(' ', $position);
            return new SilverPoint((int)$x, (int)$y, (int)$cost);
        });

        $directions = TileType::getTypes();

        $tiles = $gridPositions->map(function ($row) use ($directions) {
            [$type, $cost, $count] = explode(' ', $row);
            return new Tile($type, $directions[$type],  (int)$cost, (int)$count);
        });

        return [
            'goldenPoints' => $goldenPoints->sortBy([
                ['x', 'asc'],
                ['y', 'asc']
            ]),
            'silverPoints' => $silverPoints->sortBy([
                ['x', 'asc'],
                ['y', 'asc']
            ]),
            'tiles' => $tiles,
        ];
    }

    private function readFile(string $filename): string
    {
        $reflector = new \ReflectionClass(static::class);
        $currentPath = explode('/', $reflector->getFileName());
        array_pop($currentPath);
        $currentPath[] = Env::INPUT_DIR;
        $currentPath[] = "{$filename}.txt";
        return File::read(join('/', $currentPath));
    }
}
