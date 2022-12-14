<?php

namespace wsydney76\contentoverview\models\filters;

use craft\base\Field;
use craft\elements\db\ElementQueryInterface;
use craft\elements\Entry;
use craft\models\MatrixBlockType;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\models\Section;
use yii\base\InvalidConfigException;
use function collect;
use function count;
use function explode;

class MatrixFieldFilter extends BaseRelationFieldFilter
{
    public string $filterType = 'entriesField';
    public string $relatedToParam = '';
    public string $elementType = Entry::class;
    public Field $subField;


    public function init(): void
    {
        $segments = explode('.', $this->handle);

        if (count($segments) < 2) {
            throw new InvalidConfigException("Invalid matrix handle (field.blockType.subField)");
        }

        /** @var MatrixBlockType $blockType */
        if (count($segments) == 2) {
            $blockType = $this->field->getBlockTypes()[0];
            $subFieldHandle = $segments[1];
        } else {
            $blockType = collect($this->field->getBlockTypes())->firstWhere('handle', $segments[1]);
            if (!$blockType) {
                throw new InvalidConfigException("Invalid blocktype handle $segments[1]");
            }
            $subFieldHandle = $segments[2];
        }


        $this->subField = collect($blockType->getCustomFields())->firstWhere('handle', $subFieldHandle);
        if (!$this->subField) {
            throw new InvalidConfigException("Invalid subField handle $subFieldHandle");
        }

        // return field handle in the form relatedTo expects
        $this->relatedToParam = "{$segments[0]}.{$subFieldHandle}";

        $this->options = $this->_getOptionsForEntryField($this->subField);

    }

    public function getOptions(): array|Collection
    {
        $this->options = $this->_getOptionsForEntryField($this->subField);
        return parent::getOptions(); // TODO: Change the autogenerated stub
    }

    public function getSources() {
        return $this->subField->sources;
    }

    public function modifyQuery(Section $sectionConfig, array $filter, ElementQueryInterface $query)
    {
        $query->andRelatedTo($this->_getRelatedToParams($filter['value'], $this->relatedToParam));

    }
}