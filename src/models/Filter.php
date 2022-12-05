<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Field;
use craft\base\FieldInterface;
use craft\elements\Entry;
use craft\elements\User;
use craft\fields\BaseOptionsField;
use craft\fields\Entries;
use craft\fields\Matrix;
use craft\fields\Users;
use craft\models\MatrixBlockType;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefineCustomFilterOptionsEvent;
use wsydney76\contentoverview\events\DefineFiltersEvent;
use wsydney76\contentoverview\Plugin;
use yii\base\InvalidConfigException;
use function collect;
use function count;
use function explode;

class Filter extends BaseModel
{

    public const EVENT_DEFINE_CUSTOM_FILTER_OPTIONS = 'defineCustomFilterOptions';

    public string $type;
    public string $label = '';
    public FieldInterface $field;
    public string $subField = '';
    public string $relatedToParam = '';
    public string $orderBy = '';
    public Collection $options;
    public string $fieldType = '';
    public bool $useSelectize = false;

    protected function normalizeFilter(): void
    {
        // parent::init();
        if ($this->type === 'field') {

            $segments = explode('.', $this->handle);
            $fieldHandle = $segments[0];

            $this->field = Craft::$app->fields->getFieldByHandle($fieldHandle);

            if (!$this->field) {
                throw new InvalidConfigException("Invalid field handle");
            }

            $this->label = $this->label ?: $this->field->name;
            $this->relatedToParam = $fieldHandle;

            if ($this->field instanceof Entries) {
                $this->fieldType = 'entriesField';

                $this->options = $this->_getOptionsForEntryField($this->field);
            }

            if ($this->field instanceof Users) {
                $this->fieldType = 'usersField';
                $this->options = User::find()
                    ->orderBy($this->orderBy)
                    ->collect()
                    ->map(fn($user) => [
                        'label' => $user->name,
                        'value' => $user->id
                    ]);
            }

            if ($this->field instanceof BaseOptionsField) {
                $this->fieldType = 'optionsField';

                $this->options = collect($this->field->options)
                    ->filter(fn($option) => $option['value'] !== '');
            }

            if ($this->field instanceof Matrix) {
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


                /** @var Field $field */
                $field = collect($blockType->getCustomFields())->firstWhere('handle', $subFieldHandle);
                if (!$field) {
                    throw new InvalidConfigException("Invalid subField handle $subFieldHandle");
                }

                // return field handle in the form relatedTo expects
                $this->relatedToParam = "{$segments[0]}.{$subFieldHandle}";

                $this->options = $this->_getOptionsForEntryField($field);

                $this->fieldType = 'entriesField';
            }
            // \Craft::dd($this);
        }

        if ($this->type === 'custom') {
            $this->fieldType = 'custom';
        }

        if ($this->type === 'status') {
            $this->fieldType = 'status';
            $this->label = $this->label ?:' Status';
            $this->options = collect(Plugin::getInstance()->getSettings()->statusFilterOptions);
        }
    }

    public function getOptions()
    {
        $this->normalizeFilter();

        if ($this->hasEventHandlers(self::EVENT_DEFINE_CUSTOM_FILTER_OPTIONS)) {
            $event = new DefineCustomFilterOptionsEvent([
                'user' => Craft::$app->user->identity,
                'filter' => $this,
                'options' => $this->options
            ]);

            $this->trigger(self::EVENT_DEFINE_CUSTOM_FILTER_OPTIONS, $event);

            $this->options = $event->options;
        }

        return $this->options;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function options(array $options): self
    {
        $this->options = collect($options);
        return $this;
    }

    public function orderBy(string $orderBy): self
    {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function useSelectize(bool $useSelectize = true): self
    {
        $this->useSelectize = $useSelectize;
        return $this;
    }

    protected function _getOptionsForEntryField(Field $field)
    {
        if ($field->sources !== '*') {
            $sections = [];
            foreach ($field->sources as $source) {
                $section = Craft::$app->sections->getSectionByUid(explode(':', $source)[1]);
                $sections[] = $section->handle;
            }
        }
        return Entry::find()
            ->section($sections)
            ->orderBy($this->orderBy)
            ->collect()
            ->map(fn($entry) => [
                'label' => $entry->title,
                'value' => $entry->id
            ]);
    }

}