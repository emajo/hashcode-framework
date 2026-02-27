<?php

namespace Solutions\Reply24\Classes;

use Illuminate\Support\Collection;

class Point
{
    public function __construct(
        public int $x,
        public int $y,
    ) {
    }


    public static function connect($first, $second, Collection $tiles, $previousMovement = null): array
    {
        $startingPoint = new Point($first->x, $first->y);
        $diffX = $second->x - $first->x;
        $diffY = $second->y - $first->y;
        if ($diffX !== 0 && $diffY !== 0) {
            $diffX--;
            $diffY--;
        }
        $xDirection = '';
        $yDirection = '';
        $cDirection = '';
        $firstDirection = '';
        if ($diffX > 0) {
            $xDirection = 'leftRight';
            $cDirection = 'left';
        } elseif ($diffX < 0) {
            $xDirection = 'rightLeft';
            $cDirection = 'right';
        }
        if($diffX !== 0) {
            $firstDirection = $cDirection;
        }
        if ($diffY > 0) {
            $yDirection .= 'downUp';
            $cDirection .= 'Up';
        } elseif ($diffY < 0) {
            $yDirection .= 'upDown';
            $cDirection .= 'Down';
        }
        if(!$firstDirection) {
            $firstDirection = $cDirection;
        }
        $path = [];
        $lastMovement = '';

        if ($previousMovement) {
            switch($previousMovement) {
                case 'left':
                    $previousMovement = 'right';
                    break;
                case 'right':
                    $previousMovement = 'left';
                    break;
                case 'up':
                    $previousMovement = 'down';
                    break;
                case 'down':
                    $previousMovement = 'up';
                    break;
            }
            
            $firstTile = $tiles->where('direction.' . $previousMovement . ucfirst($firstDirection), true)->where('count', '>', 0)->sortBy('cost')->first();
            if (!$firstTile) return [];

            $firstTile->count -= 1;
            switch ($previousMovement) {
                case 'left':
                    $startingPoint->x -= 1;
                    $diffX--;
                    break;
                case 'right':
                    $startingPoint->x == 1;
                    $diffX--;
                    break;
                case 'up':
                    $startingPoint->y -= 1;
                    $diffY--;
                    break;
                case 'down':
                    $startingPoint->y += 1;
                    $diffY--;
                    break;
            }
            $path[] = "{$firstTile->type} {$startingPoint->x} {$startingPoint->y}";
        }

        if ($diffX !== 0) {
            $xTiles = $tiles->where('direction.' . $xDirection, true)->sortBy('cost');

            if (abs($diffX) > $xTiles->sum('count')) {
                return [];
            }
            $xMovements = 0;
            foreach ($xTiles as $tile) {
                for ($i = $xMovements; $i < abs($diffX); $i++) {
                    if ($tile->count === 0) {
                        break;
                    }
                    $tile->count -= 1;
                    $xMovements++;
                    $startingPoint->x += $diffX > 0 ? 1 : -1;
                    $path[] = "{$tile->type} {$startingPoint->x} {$startingPoint->y}";
                }
                if ($xMovements === abs($diffX)) {
                    break;
                }
            }
            $lastMovement = $cDirection;
        }

        if ($diffX !== 0 && $diffY !== 0) {
            $cTile = $tiles->where('direction.' . $cDirection, true)->where('count', '>', 0)->sortBy('cost')->first();
            if (!$cTile) return [];

            $cTile->count -= 1;
            $startingPoint->x += $diffX > 0 ? 1 : -1;
            $path[] = "{$cTile->type} {$startingPoint->x} {$startingPoint->y}";
        }

        if ($diffY !== 0) {
            $yTiles = $tiles->where('direction.' . $yDirection, true)->sortBy('cost');

            if (abs($diffY) > $yTiles->sum('count')) {
                return [];
            }
            $yMovements = 0;
            foreach ($yTiles as $tile) {
                for ($i = $yMovements; $i < abs($diffY); $i++) {
                    if ($tile->count === 0) {
                        break;
                    }
                    $tile->count -= 1;
                    $yMovements++;
                    $startingPoint->y += $diffY > 0 ? 1 : -1;
                    $path[] = "{$tile->type} {$startingPoint->x} {$startingPoint->y}";
                }
                if ($yMovements === abs($diffY)) {
                    break;
                }
            }
            $lastMovement = lcfirst($cDirection);
        }

        return [
            'lastMovement' => $lastMovement,
            'path' => $path
        ];
    }
}
