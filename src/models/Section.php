<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\db\Paginator;
use craft\elements\db\ElementQueryInterface;
use craft\elements\Entry;
use craft\helpers\ElementHelper;
use Illuminate\Support\Collection;
use wsydney76\contentoverview\events\DefineActionsEvent;
use wsydney76\contentoverview\events\DefineFiltersEvent;
use wsydney76\contentoverview\events\FilterContentOverviewQueryEvent;
use wsydney76\contentoverview\events\ModifyContentOverviewQueryEvent;
use wsydney76\contentoverview\Plugin;
use yii\base\InvalidConfigException;
use function array_map;
use function collect;
use function implode;
use function in_array;
use function is_array;
use function is_string;
use function round;

class Section extends BaseSection
{
    public const EVENT_MODIFY_CONTENTOVERVIEW_QUERY = 'modifyContentoverviewQuery';
    public const EVENT_FILTER_CONTENTOVERVIEW_QUERY = 'filterContentoverviewQuery';
    public const EVENT_DEFINE_ACTIONS = 'defineActionsEvent';
    public const EVENT_DEFINE_FILTERS = 'defineFiltersEvent';

    public array $actions = [];
    public bool $allSites = false;
    public array $custom = [];
    public array|string $entryType = '';
    public ?array $filters = null;
    public string $filtersPosition = 'inline';
    public array|string $icon = [];
    public array|string $imageField = [];
    public ?float $imageRatio = null;
    public array|string $info = '';
    public array|string $infoTemplate = '';
    public ?string $layout = null;
    public ?int $limit = null;
    public array|string $orderBy = '';
    public bool $ownDraftsOnly = false;
    public array|string $popupInfo = '';
    public ?ElementQueryInterface $query = null;
    public bool $search = false;
    public array $searchAttributes = [];
    public array|string $section = '';
    public ?string $scope = null;
    public ?string $size = null;
    public bool $showNewButton = true;
    public bool $showIndexButton = true;
    public ?bool $sortByScore = false;
    public ?string $status = null;
    public string $titleObjectTemplate = '{title}';


    // make it easer to detect custom sections, instead of using class names
    public bool $isCustomSection = false;

    public string $entriesTemplate = 'section_entries.twig';

    protected $_layouts = ['list', 'cardlets', 'cards', 'line', 'table'];


    /**
     * Array of actions
     * Predefined slideout|delete
     *
     * @param array $actions
     * @return $this
     */
    public function actions(array $actions): self
    {
        $this->actions = $actions;
        return $this;
    }

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
     * Sets horizontal size of layouts: small, medium, large
     *
     * @param string $size
     * @return $this
     */
    public function size(string $size): self
    {
        $this->size = $size;
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
        $this->showNewButton = $buttons;
        $this->showIndexButton = $buttons;

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
     * Set entry type handle
     *
     * @param array|string $entryType
     * @return $this
     */
    public function entryType(array|string $entryType): self
    {
        $this->entryType = $entryType;
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
     * Sets an aspect ratio for layout=cards
     *
     * @param float $imageRatio
     * @return $this
     */
    public function imageRatio(float $imageRatio): self
    {
        $this->imageRatio = $imageRatio;
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
     * Order criteria, will be passed as is to the entry query orderBy param.
     *
     * @param array|string $orderBy
     * @return $this
     */
    public function orderBy(array|string $orderBy): self
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
     * Defines base query for this section.
     * The query will still be modified with other settings.
     * A heading has be defined.
     * See Multi Section setup
     *
     * @param ElementQueryInterface $query
     * @return $this
     */
    public function query(ElementQueryInterface $query): self
    {
        $this->query = $query;

        // No sections defined where this buttons could link to
        $this->showNewButton = false;
        $this->showIndexButton = false;
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
     * Whether to show a 'New entry' button
     *
     * @param bool showNewButton
     * @return $this
     */
    public function showNewButton(bool $showNewButton): self
    {
        $this->showNewButton = $showNewButton;
        return $this;
    }

    /**
     * Whether to show a 'All entries' button
     *
     * @param bool $showIndexButton
     * @return $this
     */
    public function showIndexButton(bool $showIndexButton): self
    {
        $this->showIndexButton = $showIndexButton;
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
     * Object template that will be rendered for the layout title
     *
     * @param string $titleObjectTemplate
     * @return $this
     */
    public function titleObjectTemplate(string $titleObjectTemplate): self
    {
        $this->titleObjectTemplate = $titleObjectTemplate;
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

        if ($this instanceof Section) {
            $sections = $this->_normalizeToArray($this->section);
            $headings = array_map(fn($section) => Craft::$app->sections->getSectionByHandle($section)->name
                , $sections);

            return implode(', ', $headings);
        }

        return '';
    }

    public function getLayout() : string
    {
        return $this->layout ?? Plugin::getInstance()->getSettings()->defaultLayout;
    }

    public function getSize(): string
    {
        return $this->size ?? Plugin::getInstance()->getSettings()->layoutSizes[$this->getLayout()] ?? 'none';
    }


    public function getTransform(): array
    {
        $transform = Plugin::getInstance()->getSettings()->transforms[$this->getLayout()];

        if ($this->imageRatio) {
            $transform['height'] = round(($transform['width'] / $this->imageRatio) , 0);
        }

        return $transform;
    }

    /**
     * Is current user allowed to do this for at least one section?
     *
     * @return bool
     */
    public function getPermittedSections(string $permission): array
    {

        if ($this->query) {
            // No sections explicitly defined
            return ['*'];
        }

        $currentUser = Craft::$app->user->identity;
        $sections = [];

        foreach ($this->_normalizeToArray($this->section) as $section) {
            if ($currentUser
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
        $filters =  collect($this->filters);

        if ($this->hasEventHandlers(self::EVENT_DEFINE_FILTERS)) {
            $event = new DefineFiltersEvent([
                'user' => Craft::$app->user->identity,
                'sectionConfig' => $this,
                'filters' => $filters
            ]);

            $this->trigger(self::EVENT_DEFINE_FILTERS, $event);

            $filters = $event->filters;
        }


        return $filters;
    }

    /**
     * Get options for custom sort, if defined
     *
     * @return array
     */
    public function getOrderByOptions(): Collection
    {
        if (!is_array($this->orderBy)) {
            return collect([]);
        }

        return collect($this->orderBy);
    }


    public function getActions(Entry $entry): Collection
    {

        $actions = collect($this->actions)
            ->filter(function(Action|string $action) use ($entry) {
                if (is_string($action)) {
                    return true;
                }
                return $action->isActiveForEntry($entry);
            });


        if ($this->hasEventHandlers(self::EVENT_DEFINE_ACTIONS)) {
            $event = new DefineActionsEvent([
                'user' => Craft::$app->user->identity,
                'entry' => $entry,
                'sectionConfig' => $this,
                'actions' => $actions
            ]);

            $this->trigger(self::EVENT_DEFINE_ACTIONS, $event);

            $actions = $event->actions;
        }

        return $actions;
    }

    /**
     * Returns entries and entry count for this section
     *
     * @return array with keys entries: array of entries (respecting a limit, if set), count: number of entries (without limit)
     */
    public function getEntries(
        int $sectionPageNo = 1, string $q = '', array $filters = [], string $orderBy = ''
    ): Paginator {
        /** @var Settings $settings */
        $settings = Plugin::getInstance()->getSettings();

        $currentSite = Craft::$app->request->getParam('site', Craft::$app->sites->primarySite->handle);

        $query = $this->query ?? Entry::find()
            ->section($this->section)
            ->type($this->entryType)
            ->status(null);

        if (!$orderBy) {
            if (is_string($this->orderBy)) {
                $orderBy = (string)$this->orderBy;
            } else {
                $orderBy = $this->orderBy[0]['value'];
            }
        }

        if ($orderBy) {
            $query->orderBy($orderBy);
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
                        'withTransforms' => [$this->getTransform()]
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
                                'field' => $filter['handle']
                            ]);
                            break;
                        }
                        case 'optionsField':
                        {
                            $field = Craft::$app->fields->getFieldByHandle($filter['handle']);
                            $columnName = ElementHelper::fieldColumnFromField($field);

                            $query->andWhere([$columnName => $filter['value']]);
                            break;
                        }

                        case 'custom':
                        {

                            if ($this->hasEventHandlers(self::EVENT_FILTER_CONTENTOVERVIEW_QUERY)) {
                                $this->trigger(self::EVENT_FILTER_CONTENTOVERVIEW_QUERY, new FilterContentOverviewQueryEvent([
                                    'query' => $query,
                                    'handle' => $filter['handle'],
                                    'value' => $filter['value']
                                ]));
                            }
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