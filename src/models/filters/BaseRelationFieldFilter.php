<?php

namespace wsydney76\contentoverview\models\filters;

use Craft;
use craft\base\Field;
use craft\elements\db\ElementQueryInterface;
use craft\elements\Entry;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Section;
use function explode;

class BaseRelationFieldFilter extends BaseFieldFilter
{
    public string $orderBy = '';

    /**
     * How to order options for entries/users field
     *
     * @param string $orderBy
     * @return $this
     */
    public function orderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }


    public function modifyQuery(Section $sectionConfig, array $filter, ElementQueryInterface $query)
    {
        $query->andRelatedTo([
            'element' => $filter['value'],
            'field' => $this->field->handle
        ]);
    }

    /**
     * Get all entries for an entries field
     *
     * @param Field $field
     * @return Collection{label: string, value: string}
     */
    protected function _getOptionsForEntryField($field): Collection
    {

        if ($field->sources !== '*') {
            $sections = [];
            foreach ($field->sources as $source) {
                $section = Craft::$app->sections->getSectionByUid(explode(':', $source)[1]);
                $sections[] = $section->handle;
            }
        }
        return Entry::find()
            ->section($sections ?? null)
            ->orderBy($this->orderBy)
            ->collect()
            ->map(fn($entry) => [
                'label' => $entry->title ?: Craft::t('app', 'Untitled entry'),
                'value' => $entry->id
            ]);
    }
}