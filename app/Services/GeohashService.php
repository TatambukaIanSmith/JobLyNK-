<?php

namespace App\Services;

class GeohashService
{
    private const BASE32 = '0123456789bcdefghjkmnpqrstuvwxyz';
    
    /**
     * Encode latitude and longitude into geohash
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $precision
     * @return string
     */
    public static function encode(float $latitude, float $longitude, int $precision = 9): string
    {
        $latRange = [-90.0, 90.0];
        $lonRange = [-180.0, 180.0];
        $geohash = '';
        $bits = 0;
        $bit = 0;
        $ch = 0;

        while (strlen($geohash) < $precision) {
            if ($bit % 2 == 0) {
                // Longitude
                $mid = ($lonRange[0] + $lonRange[1]) / 2;
                if ($longitude > $mid) {
                    $ch |= (1 << (4 - $bits));
                    $lonRange[0] = $mid;
                } else {
                    $lonRange[1] = $mid;
                }
            } else {
                // Latitude
                $mid = ($latRange[0] + $latRange[1]) / 2;
                if ($latitude > $mid) {
                    $ch |= (1 << (4 - $bits));
                    $latRange[0] = $mid;
                } else {
                    $latRange[1] = $mid;
                }
            }

            $bits++;
            $bit++;

            if ($bits == 5) {
                $geohash .= self::BASE32[$ch];
                $bits = 0;
                $ch = 0;
            }
        }

        return $geohash;
    }

    /**
     * Decode geohash into latitude and longitude
     *
     * @param string $geohash
     * @return array ['latitude' => float, 'longitude' => float]
     */
    public static function decode(string $geohash): array
    {
        $latRange = [-90.0, 90.0];
        $lonRange = [-180.0, 180.0];
        $isLon = true;

        for ($i = 0; $i < strlen($geohash); $i++) {
            $char = $geohash[$i];
            $idx = strpos(self::BASE32, $char);

            for ($j = 4; $j >= 0; $j--) {
                $bit = ($idx >> $j) & 1;

                if ($isLon) {
                    $mid = ($lonRange[0] + $lonRange[1]) / 2;
                    if ($bit == 1) {
                        $lonRange[0] = $mid;
                    } else {
                        $lonRange[1] = $mid;
                    }
                } else {
                    $mid = ($latRange[0] + $latRange[1]) / 2;
                    if ($bit == 1) {
                        $latRange[0] = $mid;
                    } else {
                        $latRange[1] = $mid;
                    }
                }

                $isLon = !$isLon;
            }
        }

        return [
            'latitude' => ($latRange[0] + $latRange[1]) / 2,
            'longitude' => ($lonRange[0] + $lonRange[1]) / 2,
        ];
    }

    /**
     * Get neighboring geohashes
     *
     * @param string $geohash
     * @return array
     */
    public static function neighbors(string $geohash): array
    {
        $coords = self::decode($geohash);
        $lat = $coords['latitude'];
        $lon = $coords['longitude'];
        
        // Approximate degree offset based on geohash precision
        $precision = strlen($geohash);
        $offset = pow(2, 5 - $precision) * 0.5;

        return [
            'center' => $geohash,
            'north' => self::encode($lat + $offset, $lon, $precision),
            'south' => self::encode($lat - $offset, $lon, $precision),
            'east' => self::encode($lat, $lon + $offset, $precision),
            'west' => self::encode($lat, $lon - $offset, $precision),
            'northeast' => self::encode($lat + $offset, $lon + $offset, $precision),
            'northwest' => self::encode($lat + $offset, $lon - $offset, $precision),
            'southeast' => self::encode($lat - $offset, $lon + $offset, $precision),
            'southwest' => self::encode($lat - $offset, $lon - $offset, $precision),
        ];
    }

    /**
     * Get geohash prefix for proximity search
     *
     * @param float $latitude
     * @param float $longitude
     * @param int $radiusKm
     * @return string
     */
    public static function getPrefixForRadius(float $latitude, float $longitude, int $radiusKm): string
    {
        // Precision mapping: smaller radius = longer prefix
        // Adjusted for better coverage
        $precisionMap = [
            1 => 7,    // ~150m
            5 => 5,    // ~5km
            10 => 4,   // ~20km (covers 10km radius well)
            20 => 4,   // ~20km
            50 => 3,   // ~150km
            100 => 2,  // ~600km
        ];

        $precision = 3; // default for large radius
        foreach ($precisionMap as $radius => $prec) {
            if ($radiusKm <= $radius) {
                $precision = $prec;
                break;
            }
        }

        return self::encode($latitude, $longitude, $precision);
    }
}
