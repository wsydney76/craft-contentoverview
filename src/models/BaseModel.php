<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use Illuminate\Support\Collection;


/**
 * Implements common members/functions
 */
class BaseModel extends Model
{
    public string $handle = '';
    public array $custom = [];
    public string|array $group = '';
    public string $permission = '';


    /**
     * Sets an optional handle for a model.
     *
     * A handle can be used to identify a page/tab/column/section model in event handlers
     *
     * @param string $handle
     * @return $this
     */
    public function handle(string $handle): self
    {
        $this->handle = $handle;
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
     * User group handle(s) a user has to be member in to view the config object.
     *
     * @param string|array<string> $group
     * @return $this
     */
    public function group(string|array $group): self
    {
        $this->group = $group;
        return $this;
    }

    /**
     * Permissions a user has to match to view the config object.
     *
     * @param string $permission
     * @return $this
     */
    public function permission(string $permission): self
    {
        $this->permission = $permission;
        return $this;
    }

    /**
     * Make sure the value is an array.
     *
     * @param $value
     * @return string[]
     */
    protected function _normalizeToArray($value)
    {
        return is_string($value) ? [$value] : $value;
    }

    /**
     * Filter out config objects a user cannot view.
     *
     * @param Collection $objects
     * @return Collection
     */
    protected function filterForCurrentUser(Collection $objects)
    {
        $currentUser = Craft::$app->user->identity;

        // Admins can see everything, or no restriction set
        if ($currentUser->admin) {
            return $objects;
        }

        return $objects
            ->filter(function($object) use ($currentUser) {

                // Maybe a string, e.g a predefined action
                if (!$object instanceof BaseModel) {
                    return true;
                }

                // Check permission setting, takes precedence over 'group'
                if ($object->permission) {
                    return ($currentUser->can($object->permission));
                }

                // Check group
                if ($object->group) {
                    $groups = $this->_normalizeToArray($object->group);
                    foreach ($groups as $group) {
                        if ($currentUser->isInGroup($group)) {
                            return true;
                        }
                    }
                    return false;
                }

                // No restriction
                return true;
            });
    }

}