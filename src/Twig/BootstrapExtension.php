<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class BootstrapExtension extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('badge', [$this, 'badgeFilter'], ['is_safe' => ['html']]),
            new TwigFilter('badge_bool', [$this, 'booleanBadgeFilter'], ['is_safe' => ['html']]),
        );
    }

    public function badgeFilter($text, $type = "primary")
    {
        return "<span class='badge badge-$type'>$text</span>";
    }

    public function booleanBadgeFilter(bool $data, string $yes = "Oui", string $no = "Non")
    {
        $color = $data ? 'success' : 'danger';
        return "<span class='badge badge-$color'>" . ($data ? $yes : $no) . "</span>";
    }
}
