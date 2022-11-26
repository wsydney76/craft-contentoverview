<?php

namespace wsydney76\contentoverview\models;

use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefineTableColumnsEvent;
use wsydney76\contentoverview\Plugin;
use function collect;

class TableSection extends Section

{

    public const EVENT_DEFINE_TABLECOLUMNS = 'eventDefineTableColumns';

    public string $sectionTemplate = 'partials/section.twig';
    public array $columns = [];
    public bool $showImage = true;
    public bool $showStatus = true;
    public bool $showTitle = true;

    public string $entriesTemplate = 'tablesection_entries.twig';

    public function getColumns(): Collection
    {
        $co = Plugin::getInstance()->contentoverview;

        $columns = collect($this->columns);

        if ($this->showTitle) {
            $columns->prepend($co->createTableColumn('title')->label('Title'));
        }
        if ($this->showStatus) {
            $columns->prepend($co->createTableColumn('status')->label(''));
        }
        if ($this->showImage) {
            $columns->prepend($co->createTableColumn('image')->label('Image'));
        }


        if ($this->actions) {
            $columns->push($co->createTableColumn('actions')->label('Actions'));
        }

        if ($this->hasEventHandlers(self::EVENT_DEFINE_TABLECOLUMNS)) {
            $event = new DefineTableColumnsEvent([
                'table' => $this,
                'tableColumns' => $columns
            ]);
            $this->trigger(self::EVENT_DEFINE_TABLECOLUMNS, $event);

            $columns = $event->tableColumns;
        }

        return $columns;
    }

    public function getLayout(): string
    {
        return 'table';
    }

    public function getTransform(): array
    {
        return Plugin::getInstance()->getSettings()->transforms['table'];
    }
}