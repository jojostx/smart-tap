<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Geographical
{
  /**
   * @param Builder $query
   * @param float $latitude Latitude
   * @param float $longitude Longitude
   * @return Builder
   */
  public function scopeDistance($query, $latitude, $longitude)
  {
    $latName = $this->getQualifiedLatitudeColumn();
    $lonName = $this->getQualifiedLongitudeColumn();

    // Adding already selected columns to query, all columns will be selected by default
    if ($query->getQuery()->columns === null) {
      $query->select($this->getTable() . '.*');
    } else {
      $query->select($query->getQuery()->columns);
    }

    $sql = '(ST_Distance_Sphere(point(' . $latName . ',' . $lonName . '), point(?, ?)) * ?) as distance';

    if ($this->getResultInKilometers()) {
      $query->selectRaw($sql, [$latitude, $longitude, 0.001]);
    } else {
      $query->selectRaw($sql, [$latitude, $longitude, .000621371192]);
    }

    return $query;
  }

  public function scopeGeofence($query, $latitude, $longitude, $inner_radius, $outer_radius)
  {
    $query = $this->scopeDistance($query, $latitude, $longitude);
    return $query->havingRaw('distance BETWEEN ? AND ?', [$inner_radius, $outer_radius]);
  }

  public function scopeWithinMilesOf($query, $latitude, $longitude, $miles)
  {
    $box = static::boundingBox($latitude, $longitude, $miles);

    $query
      // Latitude part of the bounding box.
      ->whereBetween('latitude', [
        $box['minLat'],
        $box['maxLat']
      ])
      // Longitude part of the bounding box.
      ->whereBetween('longitude', [
        $box['minLon'],
        $box['maxLon']
      ])
      // Accurate calculation that eliminates false positives.
      ->whereRaw('(ST_Distance_Sphere(point(longitude, latitude), point(?,?))) <= ?', [
        $longitude,
        $latitude,
        $miles / 0.000621371192
      ]);
  }

  public static function boundingBox($latitude, $longitude, $distance)
  {
    $latLimits = [deg2rad(-90), deg2rad(90)];
    $lonLimits = [deg2rad(-180), deg2rad(180)];

    $radLat = deg2rad($latitude);
    $radLon = deg2rad($longitude);

    if (
      $radLat < $latLimits[0] || $radLat > $latLimits[1]
      || $radLon < $lonLimits[0] || $radLon > $lonLimits[1]
    ) {
      throw new \Exception("Invalid Argument");
    }

    $angular = $distance / 3958.762079;

    $minLat = $radLat - $angular;
    $maxLat = $radLat + $angular;

    if ($minLat > $latLimits[0] && $maxLat < $latLimits[1]) {
      $deltaLon = asin(sin($angular) / cos($radLat));
      $minLon = $radLon - $deltaLon;

      if ($minLon < $lonLimits[0]) {
        $minLon += 2 * pi();
      }

      $maxLon = $radLon + $deltaLon;

      if ($maxLon > $lonLimits[1]) {
        $maxLon -= 2 * pi();
      }
    } else {
      // A pole is contained within the distance.
      $minLat = max($minLat, $latLimits[0]);
      $maxLat = min($maxLat, $latLimits[1]);
      $minLon = $lonLimits[0];
      $maxLon = $lonLimits[1];
    }

    return [
      'minLat' => rad2deg($minLat),
      'minLon' => rad2deg($minLon),
      'maxLat' => rad2deg($maxLat),
      'maxLon' => rad2deg($maxLon),
    ];
  }

  protected function getQualifiedLatitudeColumn()
  {
    return $this->getConnection()->getTablePrefix() . $this->getTable() . '.' . $this->getLatitudeColumn();
  }

  protected function getQualifiedLongitudeColumn()
  {
    return $this->getConnection()->getTablePrefix() . $this->getTable() . '.' . $this->getLongitudeColumn();
  }

  public function getLatitudeColumn()
  {
    return 'latitude';
  }

  public function getLongitudeColumn()
  {
    return 'longitude';
  }

  public function getResultInKilometers()
  {
    return true;
  }
}
