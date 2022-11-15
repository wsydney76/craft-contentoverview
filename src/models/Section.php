<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Field;
use craft\base\Model;
use craft\db\Paginator;
use craft\elements\Entry;
use craft\fields\BaseOptionsField;
use craft\fields\Entries;
use craft\fields\Matrix;
use craft\fields\Users;
use craft\helpers\ElementHelper;
use craft\models\MatrixBlockType;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\ModifyContentOverviewQueryEvent;
use wsydney76\contentoverview\Plugin;
use yii\base\InvalidConfigException;
use function array_map;
use function collect;
use function explode;
use function implode;
use function in_array;
use function is_string;

class Section extends Model
{
    public const EVENT_MODIFY_CONTENTOVERVIEW_QUERY = 'modifyContentoverviewQuery';

    public bool $allSites = false;
    public bool $buttons = true;
    public array $custom = [];
    public ?array $filters = null;
    public string $filtersPosition = 'inline';
    public ?string $heading = '';
    public array|string $icon = [];
    public array|string $imageField = [];
    public array|string $info = '';
    public array|string $infoTemplate = '';
    public string $layout = '';
    public ?int $limit = null;
    public ?string $linkToPage = '';
    public ?string $orderBy = null;
    public bool $ownDraftsOnly = false;
    public array|string $popupInfo = '';
    public bool $search = false;
    public array $searchAttributes = [];
    public array|string $section = '';
    public ?string $scope = null;
    public ?bool $sortByScore = false;
    public ?string $status = null;

    protected $_layouts = ['list', 'cardlets', 'cards', 'line'];


    /**
     * Whether to show (unique) entries from all sites
     *
     * Default = false
     *
     * @param bool $allSites
     * @return $this
     */
    public function allSites(bool $allSites): self
    {
        $this->allSites = $allSites;
        return $this;
    }

    /**
     * Whether to show New entry / All entries button
     *
     * @param bool $buttons
     * @return $this
     */
    public function buttons(bool $buttons): self
    {
        $this->buttons = $buttons;
        return $this;
    }

    /**
     * Array of custom attributes
     *
     * @param array $custom
     * @return $this
     */
    public function custom(array $custom): self
    {
        $this->custom = $custom;
        return $this;
    }

    /**
     * Defines simple filters that can be applied to searches
     *
     * e.g. ['type' => 'relation', 'section' => 'topics' ]
     *
     * @param array $filters
     * @return $this
     */
    public function filters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }


    /**
     * Where filters dropdown boxes will be positioned
     *
     * @param string $filtersPosition inline|top|bottom
     * @return $this
     */
    public function filtersPosition(string $filtersPosition): self
    {
        $this->filtersPosition = $filtersPosition;
        return $this;
    }

    /**
     * Heading of the section
     *
     * Will be translated in 'site' category
     *
     * Default: Section name
     *
     * @param string $heading
     * @return $this
     */
    public function heading(string $heading): self
    {
        $this->heading = $heading;
        return $this;
    }


    /**
     * Path to a svg icon, that will be used if no image is defined
     *
     * @param string $icon
     * @return $this
     */
    public function icon(array|string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    /**
     * Get icon for entry
     *
     * @param $entry
     * @return array|string
     */
    public function getIcon($entry): array|string
    {
        return $this->_getConfigForEntry('icon', $entry);
    }

    /**
     * Site template that renders info
     *
     * @param string $infoTemplate template inside templates folder
     * @return $this
     */
    public function infoTemplate(array|string $infoTemplate): self
    {
        $this->infoTemplate = $infoTemplate;
        return $this;
    }

    /**
     * Get infoTemplate for entry
     *
     * @param $entry
     * @return array|string
     */
    public function getInfoTemplate($entry): array|string
    {
        return $this->_getConfigForEntry('infoTemplate', $entry);
    }


    /**
     * Field handle of the image to be displayed
     *
     * @param string $imageField field handle
     * @return $this
     * @throws InvalidConfigException
     */
    public function imageField(array|string $imageField): self
    {
        $this->imageField = $imageField;
        return $this;
    }

    /**
     * Get imageField for entry
     *
     * @param Entry $entry
     * @return mixed|string
     */
    public function getImageField(Entry $entry)
    {
        return $this->_getConfigForEntry('imageField', $entry);
    }


    /**
     * Twig object template
     * Multiple templates defined in an array will be display on multitple lines
     *
     * @param array|string $info Twig object template(s)
     * @return $this
     */
    public function info(array|string $info): self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * Get info for entry
     *
     * @param Entry $entry
     * @return array|string
     */
    public function getInfo(Entry $entry): string
    {
        return $this->_getConfigForEntry('info', $entry);
    }

    /**
     * Layout in which the entries will be displayd
     *
     * One of list|cardlets|cards|line
     *
     * Default: list
     *
     * @param string $layout
     * @return $this
     * @throws InvalidConfigException
     */
    public function layout(string $layout): self
    {
        if (!in_array($layout, $this->_layouts)) {
            throw new InvalidConfigException("$layout is not a valid layout.");
        }
        $this->layout = $layout;
        return $this;
    }


    /**
     * Max count of entries
     *
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }


    /**
     * Page key the section heading will be linked to. Can include a tab id as anchor
     * e.g. page2#tab1
     *
     * @param string $linkToPage
     * @return $this
     */
    public function linkToPage(string $linkToPage): self
    {
        $this->linkToPage = $linkToPage;
        return $this;
    }

    /**
     * Order criteria, will be passed as is to the entry query orderBy param.
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
     * Whether to show only drafts created by the current user
     *
     * @param bool $ownDraftsOnly
     * @return $this
     */
    public function ownDraftsOnly(bool $ownDraftsOnly): self
    {
        $this->ownDraftsOnly = $ownDraftsOnly;
        return $this;
    }


    /**
     * Twig object templates for popup info
     * Multiple templates defined in an array will be display on multitple lines
     *
     * @param array|string $info Twig object template(s)
     * @return $this
     */
    public function popupInfo(array|string $popupInfo): self
    {
        $this->popupInfo = $popupInfo;
        return $this;
    }

    /**
     * Get popupInfo for entry
     *
     * @param Entry $entry
     * @return mixed|string
     */
    public function getPopupInfo(Entry $entry): string
    {
        return $this->_getConfigForEntry('popupInfo', $entry);
    }

    /**
     * Section handle or array of section handles
     *
     * @param string $section section handle
     * @return $this
     */
    public function section(array|string $section): self
    {
        $this->section = $section;
        return $this;
    }

    /**
     * Defines whether drafts will be displayed
     *
     * all = published and all kind of drafts
     *
     * drafts = regular drafts
     *
     * provisional = provisional drafts. Also set ->ownDraftsOnly(true) makes sense...
     *
     * @param string $scope
     * @return $this
     */
    public function scope(string $scope): self
    {
        $this->scope = $scope;
        return $this;
    }


    /**
     * Whether the section is searchable
     *
     * @param bool $search
     * @return $this
     */
    public function search(bool $search): self
    {
        $this->search = $search;
        return $this;
    }

    /**
     * Array
     *
     * @param array $searchAttributes array with label / value
     * @return $this
     */
    public function searchAttributes(array $searchAttributes): self
    {
        $this->searchAttributes = $searchAttributes;
        return $this;
    }

    /**
     * Whether search results will be sorted by score
     *
     * @param bool $sortByScore
     * @return $this
     */
    public function sortByScore(bool $sortByScore): self
    {
        $this->sortByScore = $sortByScore;
        return $this;
    }

    /**
     * Filter by entry status. Will be passed as is to the entry query status setting.
     *
     * live|pending|expired|disabled
     *
     * @param string $status
     * @return $this
     */
    public function status(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get heading for the section, from config if set, else section name
     *
     * @return string
     */
    public function getHeading(): string
    {
        if ($this->heading) {
            return $this->heading;
        }

        $sections = $this->_normalizeToArray($this->section);
        $headings = array_map(fn($section) => Craft::$app->sections->getSectionByHandle($section)->name
            , $sections);

        return implode(', ', $headings);

    }


    /**
     * Is current user allowed to do this for at least one section?
     *
     * @return bool
     */
    public function getPermittedSections(string $permission): array
    {

        $currentUser = Craft::$app->user->identity;
        $sections = [];

        foreach ($this->_normalizeToArray($this->section) as $section) {
            if (Craft::$app->user->identity
                ->can($permission . ':' . Craft::$app->sections->getSectionByHandle($section)->uid)) {
                $sections[] = $section;
            }
        }

        return $sections;
    }

    /**
     * Get filters, set field type as expected by template, set fieldInstance
     *
     * @return Collection
     */
    public function getFilters(): Collection
    {
        $filters = collect($this->filters)->transform(function($filter) {
            if (!isset($filter['type'])) {

                $segments = explode('.', $filter['field']);
                $fieldHandle = $segments[0];

                $field = Craft::$app->fields->getFieldByHandle($fieldHandle);
                if (!$field) {
                    throw new InvalidConfigException("Invalid field handle");
                }

                if ($field instanceof Matrix) {
                    if (count($segments) < 2) {
                        throw new InvalidConfigException("Invalid matrix handle (field.blockType.subField)");
                    }

                    /** @var MatrixBlockType $blockType */
                    if (count($segments) == 2) {
                        $blockType = $field->getBlockTypes()[0];
                        $subFieldHandle = $segments[1];
                    } else {
                        $blockType = collect($field->getBlockTypes())->firstWhere('handle', $segments[1]);
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
                    $filter['field'] = "{$segments[0]}.{$subFieldHandle}";
                }

                if ($field instanceof Entries) {
                    $type = 'entriesField';

                    if ($field->sources !== '*') {
                        $sections = [];
                        foreach ($field->sources as $source) {
                            $section = Craft::$app->sections->getSectionByUid(explode(':', $source)[1]);
                            $sections[] = $section->handle;
                        }
                    } else {
                        $sections = null;
                    }
                    $filter['sections'] = $sections;
                }

                if ($field instanceof Users) {
                    $type = 'usersField';
                }
                if ($field instanceof BaseOptionsField) {
                    $type = 'optionsField';
                }

                $filter['fieldInstance'] = $field;
                $filter['type'] = $type;
            }
            return $filter;
        });

        return $filters;
    }

    /**
     * Returns entries and entry count for this section
     *
     * @return array with keys entries: array of entries (respecting a limit, if set), count: number of entries (without limit)
     */
    public function getEntries(
        int $sectionPageNo = 1, string $q = '', array $filters = []
    ): Paginator {
        /** @var Settings $settings */
        $settings = Plugin::getInstance()->getSettings();

        $currentSite = Craft::$app->request->getParam('site', Craft::$app->sites->primarySite->handle);

        $query = Entry::find()
            ->section($this->section)
            ->status(null);

        if ($this->orderBy) {
            $query->orderBy($this->orderBy);
        }

        if ($this->status) {
            $query->status($this->status);
        }

        if ($this->allSites) {
            $query
                ->site('*')
                ->unique()
                ->preferSites([$currentSite]);
        } else {
            $query
                ->site($currentSite);
        }

        if ($this->imageField) {

            if (is_string($this->imageField)) {
                $imageFields = [$this->imageField];
            } else {
                $imageFields = [];
                foreach ($this->imageField as $fieldHandle) {
                    if (!isset($imageFields[$fieldHandle])) {
                        $imageFields[] = $fieldHandle;
                    }
                }
            }

            foreach ($imageFields as $imageField) {
                $query->andWith([
                    $imageField, [
                        'withTransforms' => [$settings->transforms[$this->layout]]
                    ]
                ]);
            }
        }

        switch ($this->scope) {
            case 'drafts':
            {
                $query->drafts(true);
                break;
            }
            case 'provisional':
            {
                $query
                    ->provisionalDrafts(true);
                break;
            }
            case 'all':
            {
                $query
                    ->provisionalDrafts(null)
                    ->drafts(null);
                break;
            }
        }

        if ($this->scope && $this->ownDraftsOnly) {
            $query->draftCreator(Craft::$app->user->identity);
        }

        $q = trim($q);
        if ($q) {
            $query->search($q);
            if ($this->sortByScore) {
                $query->orderBy('score');
            }
        }

        if ($filters) {
            foreach ($filters as $filter) {
                if ($filter['value']) {
                    switch ($filter['type']) {
                        case 'entriesField':
                        case 'usersField':
                        {
                            $query->andRelatedTo([
                                'element' => $filter['value'],
                                'field' => $filter['field']
                            ]);
                            break;
                        }
                        case
                        'optionsField':
                        {
                            $field = Craft::$app->fields->getFieldByHandle($filter['field']);
                            $columnName = ElementHelper::fieldColumnFromField($field);

                            $query->andWhere([$columnName => $filter['value']]);
                            break;
                        }
                    }
                }
            }
        }

        if ($this->hasEventHandlers(self::EVENT_MODIFY_CONTENTOVERVIEW_QUERY)) {
            $this->trigger(self::EVENT_MODIFY_CONTENTOVERVIEW_QUERY, new ModifyContentOverviewQueryEvent([
                'query' => $query
            ]));
        }

        return new Paginator($query, [
            'currentPage' => $sectionPageNo,
            'pageSize' => $this->limit ?? 99999
        ]);
    }

    protected function _normalizeToArray($value)
    {
        return is_string($value) ? [$value] : $value;
    }

    protected function _getConfigForEntry(string $name, Entry $entry): string
    {
        if (is_string($this->$name)) {
            return $this->$name;
        }

        $key = $entry->section->handle . '.' . $entry->type->handle;
        if (isset($this->$name[$key])) {
            return $this->$name[$key];
        }

        $key = $entry->section->handle;
        if (isset($this->$name[$key])) {
            return $this->$name[$key];
        }

        if (isset($this->$name['*'])) {
            return $this->$name['*'];
        }

        return '';
    }
}