<?php

namespace App\Extensions;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class AnimalsUserProvider implements UserProvider
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
        'octodon',
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

    public function __construct(private string $password) {

    }

    public static function randomAnimal(): string {
        return sprintf('%s %s',
            Str::ucfirst(Arr::random(self::$animals)),
            Arr::random(self::$adjectives)
        );
    }

    public function retrieveById($identifier)
    {
        return new User($identifier);
    }

    public function retrieveByToken($identifier, #[\SensitiveParameter] $token): User
    {
        return new User($token);
    }

    public function updateRememberToken(Authenticatable $user, #[\SensitiveParameter] $token): void
    {
    }

    public function retrieveByCredentials(#[\SensitiveParameter] array $credentials): ?User
    {
        if ($credentials['password'] !== $this->password) {
            return null;
        }
        return new User(self::randomAnimal());
    }

    public function validateCredentials(Authenticatable $user, #[\SensitiveParameter] array $credentials): bool
    {
        return true;
    }

    public function rehashPasswordIfRequired(Authenticatable $user, #[\SensitiveParameter] array $credentials, bool $force = false)
    {
        // TODO: Implement rehashPasswordIfRequired() method.
    }
}
