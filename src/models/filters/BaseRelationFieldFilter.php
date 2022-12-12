<?php

namespace wsydney76\contentoverview\models\filters;

use Craft;
use craft\base\Field;
use craft\elements\db\ElementQueryInterface;
use craft\elements\Entry;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Section;
use function explode;


/**
 * The base class for relation fields
 */
class BaseRelationFieldFilter extends BaseFieldFilter
{
    public string $orderBy = '';
    public int $selectLimit = 1;
    public string $multiSelectOperator = 'or';
    public string $direction = 'both';

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

    /**
     * Set limit for element selects
     *
     * @param int $selectLimit
     * @return $this
     */
    public function selectLimit(int $selectLimit): self
    {
        $this->selectLimit = $selectLimit;
        return $this;
    }


    /**
     * Sets operator (and|or) if multiple elements are selected
     *
     * @param string $multiSelectOperator
     * @return $this
     */
    public function multiSelectOperator(string $multiSelectOperator): self
    {
        $this->multiSelectOperator = $multiSelectOperator;
        return $this;
    }

    /**
     * Sets direction of relationships in|out|both
     *
     * @param string $direction
     * @return $this
     */
    public function direction(string $direction): self
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * Query for related element
     *
     * @param Section $sectionConfig
     * @param array $filter
     * @param ElementQueryInterface $query
     * @return void
     */
    public function modifyQuery(Section $sectionConfig, array $filter, ElementQueryInterface $query)
    {
        $query->andRelatedTo($this->_getRelatedToParams($filter['value'], $this->field->handle));
    }

    protected function _getRelatedToParams(string $filterValue, string $fieldHandle): array
    {
        $values = collect(explode(',', $filterValue));

        $directionParam = match ($this->direction) {
            'in' => 'targetElement',
            'out' => 'sourceElement',
            default => 'element'
        };

        if ($values->count() === 1) {
            return [
                $directionParam => $filterValue,
                'field' => $fieldHandle
            ];
        }

        $params = $values->map(fn($value) => [
            $directionParam => $value,
            'field' => $fieldHandle
        ]
        )->prepend($this->multiSelectOperator);

        return $params->toArray();
    }

    /**
     * Return field sources for element selects
     *
     * @return mixed
     */
    public function getSources()
    {
        return $this->field->sources;
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