<?php
namespace App\Services;

use App\Model\Game;
use DateTime;

class Games
{
    private array $games = [];

    public function __construct()
    {
        // Beispiel Papierflieger-Modelle
        $models = ["Falke", "Adler", "Concorde", "Delta", "Swift", "Racer", "Boomerang"];

        // Namen von Teilnehmern
        $names = ["Anna", "Ben", "Clara", "David", "Ella", "Finn", "Greta", "Hans", "Isabel", "Jonas",
            "Klara", "Lukas", "Mara", "Noah", "Olivia", "Paul", "Quentin", "Rosa", "Simon", "Tina"];

        for ($i = 0; $i < 20; $i++) {
            $model = $models[array_rand($models)];
            $distance = mt_rand(5, 50) + mt_rand() / mt_getrandmax(); // 5-50 Meter mit Nachkommastelle
            $duration = mt_rand(1, 10) + mt_rand() / mt_getrandmax(); // 1-10 Sekunden mit Nachkommastelle
            $name = $names[$i]; // eindeutige Namen
            $date = new DateTime(sprintf("2025-09-%02d", mt_rand(1, 30))); // zufälliges Datum im Sept 2025

            $this->games[] = new Game($model, $distance, $duration, $name, $date);
        }
    }

    public function getGames(): array
    {
        return $this->games;
    }
}
