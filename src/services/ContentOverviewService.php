<?php

namespace wsydney76\contentoverview\services;

use Craft;
use craft\base\Component;
use wsydney76\contentoverview\models\Column;
use wsydney76\contentoverview\models\Section;
use wsydney76\contentoverview\models\Tab;

class ContentOverviewService extends Component
{

    public function createTab($label, $id, $columns, $scope = 'all')
    {
        return new Tab([
            'label' => $label,
            'id' => $id,
            'columns' => $columns,
            'scope' => $scope
        ]);
    }

    public function createColumn($width = 12, $sections = [])
    {
        return new Column([
            'width' => $width,
            'sections' => $sections
        ]);
    }

    public function createSection(string $className = Section::class): Section
    {
        return Craft::createObject($className);
    }

}