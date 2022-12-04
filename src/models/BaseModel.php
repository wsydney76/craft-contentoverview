<?php

namespace wsydney76\contentoverview\models;

use Craft;
use craft\base\Model;
use Illuminate\Support\Collection;
use function is_string;

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

    public function group(string|array $group): self
    {
        $this->group = $group;
        return $this;
    }

    public function permission(string $permission): self
    {
        $this->permission = $permission;
        return $this;
    }

    protected function _normalizeToArray($value)
    {
        return is_string($value) ? [$value] : $value;
    }

    protected function filterForCurrentUser(Collection $objects)
    {
        $currentUser = Craft::$app->user->identity;

        // Admins can see everything, or no restriction set
        if ($currentUser->admin || (!$this->permission && !$this->group)) {
            return $objects;
        }

        return $objects
            ->filter(function($object) use ($currentUser) {

                // Maybe a string, e.g a predefined action
                if (!$object instanceof BaseModel) {
                    return true;
                }


                if ($object->permission) {
                    return ($currentUser->can($object->permission));
                }

                if ($object->group) {
                    $groups = $this->_normalizeToArray($object->group);
                    foreach ($groups as $group) {
                        if ($currentUser->isInGroup($group)) {
                            return true;
                        }
                    }
                    return false;
                }

                return true;
            });
    }

}