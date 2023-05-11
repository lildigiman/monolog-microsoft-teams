<?php

namespace CMDISP\MonologMicrosoftTeams;

use Monolog\Formatter\FormatterInterface;

class TeamsFormatter implements FormatterInterface
{
    public function format(array $record): array
    {
        return [
            'text' => '**' . $record['level_name'] . '**: ' . $record['message'],
            'sections' => [
                [
                    'facts' => $this->facts($record['context']),
                ],
            ],
        ];
    }

    public function formatBatch(array $records): array
    {
        foreach ($records as $key => $record) {
            $records[$key] = $this->format($record);
        }

        return $records;
    }

    private function facts(array $context): array
    {
        $facts = [];

        foreach ($context as $name => $value) {
            $facts[] = [
                'name' => $name,
                'value' => $value,
            ];
        }

        return $facts;
    }
}
