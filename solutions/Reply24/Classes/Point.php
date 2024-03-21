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


    public static function connect($first, $second, Collection $tiles): array
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
        if ($diffX > 0) {
            $xDirection = 'leftRight';
            $cDirection = 'left';
        } elseif ($diffX < 0) {
            $xDirection = 'rightLeft';
            $cDirection = 'right';
        }
        if ($diffY > 0) {
            $yDirection .= 'downUp';
            $cDirection .= 'Up';
        } elseif ($diffY < 0) {
            $yDirection .= 'upDown';
            $cDirection .= 'Down';
        }
        $path = [];

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
        }

        return $path;
    }
}
