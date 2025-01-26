<?php

namespace App;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class AuthService
{

    private static $adjectives = [
        'beau',
        'joli',
        'grand',
        'intelligent',
        'rapide',
        'lent',
        'fort',
        'heureux',
        'triste',
        'sombre',
        'lumineux',
        'calme',
        'bruyant',
        'doux',
        'amer',
        'énergique',
        'fatigué',
        'créatif',
        'ennuyeux',
        'passionnant',
        'chaleureux',
        'froid',
        'gentil',
        'méchant',
        'riche',
        'pauvre',
        'sage',
        'fou',
        'loyal',
        'déloyal',
        'sincère',
        'hypocrite',
        'prudent',
        'imprudent',
        'optimiste',
        'pessimiste',
        'ouvert',
        'fermé',
        'mignon',
        'laid',
        'élégant',
        'rustique',
        'moderne',
        'ancien'
    ];

    private static $animals = [
        // Animaux domestiques
        'chat',
        'chien',
        'lapin',
        'hamster',
        "octodon",
        'perroquet',
        'canari',
        'poisson',
        'corgi',

        // Animaux de la ferme
        'cheval',
        'mouton',
        'cochon',
        'coq',
        'âne',
        'bouc',

        // Animaux sauvages
        'lion',
        'tigre',
        'éléphant',
        'zèbre',
        'rhinocéros',
        'guépard',
        'panda',
        'koala',
        'kangourou',

        // Animaux marins
        'dauphin',
        'requin',
        'orque',
        'phoque',

        // Animaux exotiques
        'serpent',
        'crocodile',
        'caméléon',
        'toucan',

        // Animaux de la forêt
        'renard',
        'loup',
        'ours',
        'écureuil',
        'sanglier',

        // Animaux rares
        'okapi',
        'manchot',
        'ornithorynque',
        'tatou',
        'wallaby'
    ];

    private static ?User $user = null;

    private const COOKIE_NAME = 'username';

    public static function getUser (): User {
        if (self::$user) {
            return self::$user;
        }

        $username = Cookie::get(self::COOKIE_NAME);
        if (!$username) {
            $username = sprintf('%s %s',
                Str::ucfirst(Arr::random(self::$animals)),
                Arr::random(self::$adjectives)
            );
            Cookie::queue(self::COOKIE_NAME, $username, 6000);
        }

        self::$user = new User($username);
        return self::$user;
    }

}
