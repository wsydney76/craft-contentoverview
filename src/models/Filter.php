<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\FieldInterface;
use craft\elements\Entry;
use craft\elements\User;
use craft\fields\BaseOptionsField;
use craft\fields\Entries;
use craft\fields\Users;
use Illuminate\Support\Collection;
use yii\base\InvalidConfigException;
use function collect;
use function explode;

class Filter extends BaseModel
{
    public string $type;
    public string $label = '';
    public FieldInterface $field;
    public string $subField = '';
    public string $relatedToParam = '';
    public string $orderBy = '';
    public Collection $options;
    public ?array $sections = null;
    public string $fieldType = '';

    public function init(): void
    {
        parent::init();
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

                if ($this->field->sources !== '*') {
                    $this->sections = [];
                    foreach ($this->field->sources as $source) {
                        $section = Craft::$app->sections->getSectionByUid(explode(':', $source)[1]);
                        $this->sections[] = $section->handle;
                    }
                }
                $this->options = Entry::find()
                    ->section($this->sections)
                    ->orderBy($this->orderBy)
                    ->collect()
                    ->map(fn ($entry) => [
                        'label' => $entry->title,
                        'value' => $entry->id
                    ]);
            }

            if ($this->field instanceof Users) {
                $this->fieldType = 'usersField';
                $this->options = User::find()
                    ->orderBy($this->orderBy)
                    ->collect()
                    ->map(fn ($user) => [
                        'label' => $user->name,
                        'value' => $user->id
                    ]);
            }

            if ($this->field instanceof BaseOptionsField) {
                $this->fieldType = 'optionsField';

                $this->options = collect($this->field->options)
                    ->filter(fn($option) => $option['value'] !== '');
            }


            
            // \Craft::dd($this);
        }
        if ($this->type === 'custom') {
            $this->fieldType = 'custom';
        }

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

}