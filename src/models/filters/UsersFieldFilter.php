<?php

namespace wsydney76\contentoverview\models\filters;

use craft\elements\User;
use Illuminate\Support\Collection;

/**
 * Class for users fields
 */
class UsersFieldFilter extends BaseRelationFieldFilter
{
    public string $filterType = 'usersField';
    public array|string|null $userGroups = null;
    public string $elementType = User::class;

    /**
     * Get Options
     *
     * @return Collection
     */
    public function getOptions(): Collection
    {

        // element selects will query for options on its own
        if ($this->useElementSelect) {
            return collect([]);
        }

        $this->options = User::find()
            ->orderBy($this->orderBy)
            ->group($this->userGroups)
            ->collect()
            ->map(fn($user) => [
                'label' => $user->name,
                'value' => $user->id
            ]);

        return parent::getOptions();
    }

    /**
     * Sets User Groups
     *
     * @param array|string $userGroups
     * @return $this
     */
    public function userGroups(array|string $userGroups): self
    {
        $this->userGroups = $userGroups;
        return $this;
    }


}