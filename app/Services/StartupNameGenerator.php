<?php

namespace App\Services;

class StartupNameGenerator
{
    private array $prefixes;
    private array $roots;
    private array $suffixes;
    private array $domains;

    public function __construct(
        array $prefixes = [],
        array $roots = [],
        array $suffixes = [],
        array $domains = []
    ) {
        $this->prefixes = $prefixes ?: config('startups.prefixes', ['Inno', 'Tech', 'Digi', 'Cyber', 'Quantum', 'Cloud', 'Block', 'AI', 'Eco', 'Smart']);
        $this->roots = $roots ?: config('startups.roots', ['Sync', 'Pulse', 'Wave', 'Nexus', 'Sphere', 'Logic', 'Byte', 'Mind', 'Flow', 'Drift']);
        $this->suffixes = $suffixes ?: config('startups.suffixes', ['ify', 'ly', 'ble', 'io', 'ize', 'ify', 'app', 'hub', 'base', 'box']);
        $this->domains = $domains ?: config('startups.domains', ['tech', 'io', 'ai', 'app', 'co', 'digital', 'space', 'net', 'labs', 'works']);
    }

    public function generate(int $count = 5): array
    {
        $names = [];
        $count = max(1, min($count, config('startups.max_names', 20)));

        for ($i = 0; $i < $count; $i++) {
            $structureType = rand(1, 3);
            $name = $this->buildName($structureType);
            $domain = $this->getRandomItem($this->domains);
            
            $names[] = [
                'name' => $name,
                'domain' => "$name.$domain",
                'structure_type' => $structureType,
            ];
        }
        
        return $names;
    }
    
    private function buildName(int $structureType): string
    {
        return match ($structureType) {
            1 => $this->getRandomItem($this->prefixes) . $this->getRandomItem($this->roots),
            2 => $this->getRandomItem($this->roots) . $this->getRandomItem($this->suffixes),
            3 => $this->getRandomItem($this->prefixes) . $this->getRandomItem($this->roots) . $this->getRandomItem($this->suffixes),
            default => $this->getRandomItem($this->roots),
        };
    }
    
    private function getRandomItem(array $items): string
    {
        return $items[array_rand($items)];
    }
}