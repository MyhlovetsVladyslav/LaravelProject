<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchBusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $seats = $this->transport->transportable->seats;
        foreach ($seats as $seat) {
            $seatProperty = $seat->seat;
        }
        return [
            'id' => $this->id,
            'departure_time' => $this->departure_time,
            'arrival_time' => $this->arrival_time,
            'route' => [
                'id' => $this->route->id,
                'routable' => [
                    'id' => $this->route->routable->id,
                    'departure_location' => $this->route->routable->departure_location,
                    'arrival_location' => $this->route->routable->arrival_location,
                    'distance' => $this->route->routable->distance,
                    'duration' => $this->route->routable->duration,
                ],
            ],
            'transport' => [
                'id' => $this->transport->id,
                'type' => $this->transport->type,
                'transportable' => [
                    'id' => $this->transport->transportable->id,
                    'number' => $this->transport->transportable->number,
                    'type' => $this->transport->transportable->type,
                    'seats' => $this->transport->transportable->seats->map(function ($seat) {
                        return [
                            'id' => $seat->id,
                            'seat_number' => $seat->seat_number,
                            'seat' => [
                                'id' => $seat->seat->id,
                                'is_enabled' => !$seat->seat->tickets()->where('trip_id', $this->id)->exists()
                            ]
                        ];
                    }),
                ],
            ],
        ];
    }
}
