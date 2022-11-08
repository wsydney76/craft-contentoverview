<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use craft\elements\Entry;
use wsydney76\contentoverview\events\ModifyContentOverviewQueryEvent;
use wsydney76\contentoverview\Plugin;
use yii\base\InvalidConfigException;
use function in_array;

class Section extends Model
{
    public const EVENT_MODIFY_CONTENTOVERVIEW_QUERY = 'modifyContentoverviewQuery';

    public bool $allSites = false;
    public bool $buttons = true;
    public array $custom = [];
    public ?string $heading = '';
    public ?string $icon = null;
    public ?string $imageField = null;
    public array|string $info = '';
    public string $layout = '';
    public ?int $limit = null;
    public ?string $orderBy = null;
    public bool $ownDraftsOnly = false;
    public array|string $popupInfo = '';
    public string $section = '';
    public ?string $scope = null;
    public ?string $status = null;

    protected $_layouts = ['list', 'cardlets', 'cards'];

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
    public function icon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }


    /**
     * Field handle of the image to be displayed
     *
     * @param string $imageField field handle
     * @return $this
     * @throws InvalidConfigException
     */
    public function imageField(string $imageField): self
    {
        $field = Craft::$app->fields->getFieldByHandle($imageField);
        if (!$field) {
            throw new InvalidConfigException("$imageField is not a valid field handle.");
        }
        $this->imageField = $imageField;
        return $this;
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
     * Layout in which the entries will be displayd
     *
     * One of list|cardlets|cards
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
     * Section handle or array of section handles
     *
     * @param string $section section handle
     * @return $this
     */
    public function section(string $section): self
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
        return $this->heading != '' ? $this->heading : Craft::$app->sections->getSectionByHandle($this->section)->name;
    }

    /**
     * Is current user allowed to view the section?
     *
     * @return bool
     */
    public function userCanView(): bool
    {
        return Craft::$app->user->identity
            ->can('viewentries:'. Craft::$app->sections->getSectionByHandle($this->section)->uid);
    }

    /**
     * Is current user allowd to save entries in the section?
     *
     * @return bool
     */
    public function userCanSave(): bool
    {
        return Craft::$app->user->identity
            ->can('saveentries:'. Craft::$app->sections->getSectionByHandle($this->section)->uid);
    }


    /**
     * Returns entries and entry count for this section
     *
     * @return array with keys entries: array of entries (respecting a limit, if set), count: number of entries (without limit)
     */
    public function getEntries(): array
    {
        /** @var Settings $settings */
        $settings = Plugin::getInstance()->getSettings();

        $currentSite = Craft::$app->request->getParam('site', Craft::$app->sites->primarySite->handle);

        $query = Entry::find()
            ->section($this->section)
            ->status(null);

        if ($this->limit) {
            $query->limit($this->limit);
        }

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
            $query->with([
                [$this->imageField, [
                    'withTransforms' =>  [$settings->transforms[$this->layout]]
                ]]
            ]);
        }

        switch ($this->scope) {
            case 'drafts': {
                $query->drafts(true);
                break;
            }
            case 'provisional': {
                $query
                    ->provisionalDrafts(true);
                break;
            }
            case 'all': {
                $query
                    ->provisionalDrafts(null)
                    ->drafts(null);
                break;
            }
        }

        if($this->scope && $this->ownDraftsOnly ) {
            $query->draftCreator(Craft::$app->user->identity);
        }

        if ($this->hasEventHandlers(self::EVENT_MODIFY_CONTENTOVERVIEW_QUERY)) {
            $this->trigger(self::EVENT_MODIFY_CONTENTOVERVIEW_QUERY, new ModifyContentOverviewQueryEvent([
                'query' => $query
            ]));
        }

        return [
            'entries' => $query->collect(),
            'count' => $query->count()
        ];

    }

}